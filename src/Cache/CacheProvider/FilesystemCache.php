<?php

namespace App\Cache\CacheProvider;

use App\Cache\CacheItem;
use App\Cache\CacheItemInterface;
use App\Cache\CacheItemPool;
use App\Cache\CacheItemPoolInterface;
use App\Cache\InvalidArgumentException;


class FilesystemCache implements CacheItemPoolInterface
{
    /**
     * @var string
     */
    private $directory;

    /**
     * FilesystemCache constructor.
     *
     * @param null $directory
     */
    public function __construct($directory = null)
    {
        if (is_null($directory)) {
            $directory = sys_get_temp_dir() . '/currency-cache';
        }

        if (!file_exists($dir = $directory . '/.')) {
            @mkdir($directory, 0777, true);
        }

        $this->directory = realpath($dir) . DIRECTORY_SEPARATOR;
    }

    public function hasItem($key)
    {
        return $this->getItem($key)->isHit();
    }

    public function save(CacheItemInterface $item)
    {
        $expiresAt = $item->getExpiration() ?: 86400; // 86400s = 1 day
        $tmp = $this->directory . uniqid('', true);
        $file = $this->getCacheFile($item->getKey());
        $value = serialize($item->get());
        if (false !== @file_put_contents($tmp, $value)) {
            @touch($tmp, $expiresAt);
            @rename($tmp, $file);
        }

        return true;
    }

    protected function extract($key) {
        $value = null;
        $file = $this->getCacheFile($key);

        if (!file_exists($file) || !is_readable($file)) {
            return $value;
        }

        if (time() >= @filemtime($file)) {
            @unlink($file);
        } else {
            $value = unserialize(file_get_contents($file));
        }

        return $value;
    }

    public function getItem($key)
    {
        $item = new CacheItem($key);
        $value = $this->extract($key);
        $item->set($value);

        return $item;
    }

    private function getCacheFile($key)
    {
        return $this->directory . md5($key);
    }
}