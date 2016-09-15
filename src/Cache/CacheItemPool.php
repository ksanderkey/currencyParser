<?php

namespace App\Cache;

class CacheItemPool implements CacheItemPoolInterface
{
    public function getItem($key)
    {
        $item = new CacheItem();
        $item->setKey($key);
//        $item->setPool($this);
//
//        $item->value = $value;
//        $item->isHit = $isHit;

        return $item;
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