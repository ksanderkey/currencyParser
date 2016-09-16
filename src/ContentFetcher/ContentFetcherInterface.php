<?php

namespace App\ContentFetcher;

/**
 * Interface ContentFetcher
 */
interface ContentFetcherInterface
{
    /**
     * Get(download) page content by the given url.
     *
     * @param string $url Page address
     *
     * @return string Page content
     */
    public function fetch($url);
}