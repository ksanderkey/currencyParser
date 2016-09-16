<?php

namespace App;

use App\Cache\CacheItemPoolInterface;
use App\ContentFetcher\ContentFetcherInterface;
use App\Viewer\ViewerInterface;

/**
 * Application
 */
class App
{
    /**
     * @var ViewerInterface
     */
    protected $viewer;

    /**
     * @var CacheItemPoolInterface
     */
    protected $cache;

    /**
     * @var ContentFetcherInterface
     */
    protected $fetcher;

    /**
     * App constructor.
     * @param ViewerInterface $viewer
     * @param CacheItemPoolInterface $cache
     * @param ContentFetcherInterface $fetcher
     */
    public function __construct(ViewerInterface $viewer, CacheItemPoolInterface $cache, ContentFetcherInterface $fetcher)
    {
        $this->viewer = $viewer;
        $this->cache = $cache;
        $this->fetcher = $fetcher;
    }

    /**
     * Start app
     */
    public function run()
    {
        $template = __DIR__ . DIRECTORY_SEPARATOR . "Resources/views/base.html.php";
        $init = [
            'Euro' => 'http://resources.finance.ua/ru/public/currency-cash.xml',
            'Dollar' => 'http://resources.finance.ua/ru/public/currency-cash.json',
            'Bitcoin' => 'http://ru.investing.com/currencies/btc-usd',
            'Oil' => 'https://news.yandex.ru/quotes/1006.html'
        ];
        $currencies = [];

        foreach ($init as $key => $src) {
            $latestCurrency = $this->cache->getItem($key . '_currency');
            $newCurrency = null;
            if (!$latestCurrency->isHit()) {
                if (method_exists($this, 'parse' . $key)) {
                    $newCurrency = call_user_func(array($this, 'parse' . $key), $src);
                }

                $latestCurrency->expiresAfter(600); // 10m
                $this->cache->save($latestCurrency->set($newCurrency));
            } else {
                $newCurrency = $latestCurrency->get();
            }

            $currencies[$key] = $newCurrency;
        }

        $currenciesLabels = ['Oil' => 'ГРН / БАР.',
            'Bitcoin' => 'ГРН / 1 BTC.',
            'Euro' => 'ГРН / 1 €.',
            'Dollar' => 'ГРН / 1 $.',
        ];

        echo $this->viewer->render($template, ['currencies' => $currencies, 'labels' => $currenciesLabels]);
    }

    /**
     * html content
     *
     * @return null
     */
    public function parseOil($url)
    {
        $value = null;
        $content = $this->fetcher->fetch($url);
        $dom = new \DOMDocument();
        $pageLoaded = @$dom->loadHTML($content);
        $domXPath = new \DOMXPath($dom);

        // @TODO Add current date filter to XPath
        $nodes = $domXPath->query("//td[@class='quote__date']/parent::*/td[@class='quote__value']");
        if (0 !== $nodes->length) {
            $value = (float)$nodes[0]->nodeValue;
        }

        // get usd
        $usd = $this->cache->getItem('Dollar_currency')->get();

        return $value * $usd;
    }

    /**
     * html content
     *
     * @return null
     */
    public function parseBitcoin($url)
    {
        $value = null;
        $content = $this->fetcher->fetch($url);
        $dom = new \DOMDocument();
        $pageLoaded = @$dom->loadHTML($content);
        $domXPath = new \DOMXPath($dom);

        $nodes = $domXPath->query("//span[@id='last_last']");
        if (1 === $nodes->length) {
            $value = (float)$nodes[0]->nodeValue;
        }

        // get usd
        $usd = $this->cache->getItem('Dollar_currency')->get();

        return $value * $usd;
    }

    /**
     * xml content
     *
     * @param $url
     *
     * @return float|null
     */
    public function parseEuro($url)
    {
        $value = null;
        $content = new \SimpleXMLElement($this->fetcher->fetch($url));
        $result = $content->xpath("//title[@value='ПриватБанк']/parent::organization/currencies/c[@id='EUR']");
        $value = (float)$result[0]->attributes()['br'];

        return $value;
    }

    /**
     * json content
     *
     * @return null
     */
    public function parseDollar($url)
    {
        $value = null;
        $content = json_decode($this->fetcher->fetch($url), true);
        if (isset($content['organizations'])) {
            foreach ($content['organizations'] as $organization) {
                if ('ПриватБанк' === $organization['title']) {
                    $value = (float)$organization['currencies']['USD']['ask'];
                    break;
                }
            }
        }

        return $value;
    }
}