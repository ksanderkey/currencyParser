<?php

namespace App\Cache;

class CacheItem implements CacheItemInterface
{
    protected $key;
    protected $value;
    protected $isHit;
    protected $expiration;

    /**
     * CacheItem constructor.
     *
     * @param $key
     * @param $value
     */
    public function __construct($key, $value = null)
    {
        $this->key = $key;
        if (null !== $value) {
            $this->value = $value;
        }
    }

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
     * @return mixed
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * {@inheritdoc}
     */
    public function isHit()
    {
        return (null !== $this->value);
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
        if ($time instanceof \DateInterval) {
            $this->expiration = (int)\DateTime::createFromFormat('U', time())->add($time)->format('U');
        } elseif (is_int($time)) {
            $this->expiration = $time + time();
        } else {
            $this->expiration = null;
        }

        return $this;
    }
}