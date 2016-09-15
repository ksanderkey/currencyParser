<?php

namespace App\Cache;

/**
 * Interface CacheItemPoolInterface
 *
 * @TODO: use http://www.php-fig.org/psr/psr-6/
 */
interface CacheItemPoolInterface
{
    /**
     * Returns a Cache Item representing the specified key.
     *
     * @param string $key
     *   The key for which to return the corresponding Cache Item.
     *
     * @return CacheItemInterface
     *   The corresponding Cache Item.
     */
    public function getItem($key);

    /**
     * Confirms if the cache contains specified cache item.
     *
     * @param string $key
     *   The key for which to check existence.
     *
     * @return bool
     *   True if item exists in the cache, false otherwise.
     */
    public function hasItem($key);

    /**
     * Persists a cache item immediately.
     *
     * @param CacheItemInterface $item
     *   The cache item to save.
     *
     * @return bool
     *   True if the item was successfully persisted. False if there was an error.
     */
    public function save(CacheItemInterface $item);
}