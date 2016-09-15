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

        //$cache = new \Symfony\Component\Cache\Adapter\FilesystemAdapter();
//        $this->cache;

        //$latestNews = $cache->getItem('latest_news');
        //$latestNews->expiresAfter(600);
        //
        //if (!$latestNews->isHit()) {
        //    // do some heavy computation
        //    $news = "SUPADUPA";
        //    $cache->save($latestNews->set($news));
        //} else {
        //    $news = $latestNews->get();
        //}
        //
        //var_dump($cache);die;
        //var_dump($news);die;

        echo $this->viewer->render($template, ['testVar' => "Jack"]);
    }
}