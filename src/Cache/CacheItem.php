<?php

namespace App\Cache;

class CacheItem implements CacheItemInterface
{
    protected $key;
    protected $value;
    protected $isHit;
    protected $expiry;
    protected $defaultLifetime;
    protected $innerItem;
    protected $poolHash;

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function isHit()
    {
        return $this->isHit;
    }

    /**
     * {@inheritdoc}
     */
    public function set($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function expiresAfter($time)
    {
        if (null === $time) {
            $this->expiry = $time;
        } elseif ($time instanceof \DateInterval) {
            $this->expiry = (int) \DateTime::createFromFormat('U', time())->add($time)->format('U');
        } elseif (is_int($time)) {
            $this->expiry = $time + time();
        }

        return $this;
    }
}