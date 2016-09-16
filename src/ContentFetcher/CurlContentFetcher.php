<?php

namespace App\ContentFetcher;

/**
 * Class CurlContentFetcher
 */
class CurlContentFetcher implements ContentFetcherInterface
{
    protected $options;
    protected $userAgent;

    /**
     * CurlContentFetcher constructor.
     *
     * Check if the cURL extension is loaded.
     *
     * @param array $options
     */
    public function __construct(array $options = array(), $userAgent = null)
    {
        if (!extension_loaded('curl')) {
            throw new \RuntimeException('The cURL extension is required to use the cURL content fetcher.');
        }

        $this->options = $options;
        $this->userAgent = $userAgent ?: "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36";
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);
        $pageContent = curl_exec($curl);
        curl_close($curl);
        
        return $pageContent;
    }
}