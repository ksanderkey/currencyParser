<?php

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

$cache = new \Symfony\Component\Cache\Adapter\FilesystemAdapter();

$latestNews = $cache->getItem('latest_news');
$latestNews->expiresAfter(600);

if (!$latestNews->isHit()) {
    // do some heavy computation
    $news = "SUPADUPA";
    $cache->save($latestNews->set($news));
} else {
    $news = $latestNews->get();
}

var_dump($cache);die;
var_dump($news);die;