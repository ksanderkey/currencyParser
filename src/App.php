<?php

namespace App;

use App\Cache\CacheItemPoolInterface;
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
     * App constructor.
     * @param ViewerInterface $viewer
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(ViewerInterface $viewer, CacheItemPoolInterface $cache)
    {
        $this->viewer = $viewer;
        $this->cache = $cache;
    }

    /**
     * Start app
     */
    public function run()
    {
        $template = __DIR__ . DIRECTORY_SEPARATOR . "Resources/views/base.html.php";

        $latestCurrency = $this->cache->getItem('latest_currency');
        if (!$latestCurrency->isHit()) {
//            // do some heavy computation
            $news = "SUPADUPA@";
            $latestCurrency->expiresAfter(600);
            $this->cache->save($latestCurrency->set($news));
        } else {
            $news = $latestCurrency->get();
        }

        $currency = ['Oil' => '123',
            'Bitcoin' => '321',
            'Euro' => '28',
            'Dollar' => '25',
        ];

        echo $this->viewer->render($template, ['currency' => $currency]);
    }
}