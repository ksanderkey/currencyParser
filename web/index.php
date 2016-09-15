<?php

use App\App;
use App\Viewer\Viewer;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

$viewer = new Viewer();

$app = new App($viewer);
$app->run();


//$cache = new \Symfony\Component\Cache\Adapter\FilesystemAdapter();
//
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