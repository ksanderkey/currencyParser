<?php

// to serve static files
$filename = __DIR__ . preg_replace( '#(\?.*)$#', '', $_SERVER['REQUEST_URI'] );
if ( php_sapi_name() === 'cli-server' && is_file( $filename ) ) {
    return false;
}

use App\App;
use App\Viewer\Viewer;
use App\Cache\CacheProvider\FilesystemCache;
use App\ContentFetcher\CurlContentFetcher;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

$webRoot = __DIR__;
$cacheDir = $webRoot . DIRECTORY_SEPARATOR . 'currency-cache';
$viewer = new Viewer();
$cache = new FilesystemCache($cacheDir);
$fetcher = new CurlContentFetcher();

$app = new App($viewer, $cache, $fetcher);
$app->run();