<?php

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