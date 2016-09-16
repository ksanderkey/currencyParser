<?php

namespace App\ContentFetcher;

/**
 * Class FileContentFetcher
 */
class FileContentFetcher implements ContentFetcherInterface
{
    /**
     * @var array Context config
     */
    protected $opts = [];

    /**
     * FileContentFetcher constructor.
     *
     * Initialises context.
     */
    public function __construct()
    {
        $this->opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Connection: close\r\n"
            )
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     * @TODO review throwing exception. Maybe better to avoid it here.
     */
    function fetch($url)
    {
        $context = stream_context_create($this->opts);
        $pageContent = file_get_contents($url, false, $context);

        if (false === $pageContent) {
            throw new \Exception('Couldn\'t get contents from ' . $url);
        }

        return $pageContent;
    }
}