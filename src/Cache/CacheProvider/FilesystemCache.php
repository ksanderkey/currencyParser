<?php

namespace App\Cache\CacheProvider;

use App\Cache\CacheItemInterface;
use App\Cache\CacheItemPool;
use App\Cache\InvalidArgumentException;


class FilesystemCache extends CacheItemPool
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
        if (!is_null($directory)) {
            $directory = sys_get_temp_dir().'/currency-cache';
        }

        if (!file_exists($dir = $directory.'/.')) {
            @mkdir($directory, 0777, true);
        }

        $this->directory = realpath($dir);
    }

    public function getItems(array $keys = array())
    {
        $items = array();
        foreach ($keys as $key) {
            $item = $this->getItem($key);
            $items[$item->getKey()] = $item;
        }
        return new \ArrayIterator($items);
    }

    public function hasItem($key)
    {
        return $this->getItem($key)->isHit();
    }

    public function save(CacheItemInterface $item)
    {
        return $item->save();
    }
}