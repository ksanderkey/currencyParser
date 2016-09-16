<?php

// to serve static files
$filename = __DIR__ . preg_replace( '#(\?.*)$#', '', $_SERVER['REQUEST_URI'] );
if ( php_sapi_name() === 'cli-server' && is_file( $filename ) ) {
    return false;
}

use App\App;
use App\Viewer\Viewer;
use App\Cache\CacheProvider\FilesystemCache;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

$viewer = new Viewer();
$cache = new FilesystemCache();

$app = new App($viewer, $cache);
$app->run();