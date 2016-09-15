<?php

namespace App\Cache;

/**
 * Interface CacheItemInterface
 *
 * @TODO: use http://www.php-fig.org/psr/psr-6/
 *
 */
interface CacheItemInterface
{
    /**
     * Returns the key for the current cache item.
     *
     * @return string
     *   The key string for this cache item.
     */
    public function getKey();

    /**
     * Retrieves the value of the item from the cache associated with this object's key.
     *
     * @return mixed
     *   The value corresponding to this cache item's key, or null if not found.
     */
    public function get();

    /**
     * Confirms if the cache item lookup resulted in a cache hit.
     *
     * @return bool
     *   True if the request resulted in a cache hit. False otherwise.
     */
    public function isHit();

    /**
     * Sets the value represented by this cache item.
     *
     * @param mixed $value
     *   The serializable value to be stored.
     *
     * @return static
     *   The invoked object.
     */
    public function set($value);


    /**
     * Sets the expiration time for this cache item.
     *
     * @param int|\DateInterval|null $time
     *   The period of time from the present after which the item MUST be considered
     *   expired. An integer parameter is understood to be the time in seconds until
     *   expiration. If null is passed explicitly, a default value MAY be used.
     *   If none is set, the value should be stored permanently or for as long as the
     *   implementation allows.
     *
     * @return static
     *   The called object.
     */
    public function expiresAfter($time);
}