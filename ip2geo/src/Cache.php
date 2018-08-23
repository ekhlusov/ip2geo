<?php
/**
 * Обертка для Memcache
 * Cache
 */
class Cache
{
    /**
     * @var bool
     */
    public $mc;

    /**
     * Cache constructor.
     */
    public function __construct()
    {
        $this->mc = memcache_connect('localhost', 11211);
    }

    /**
     * @param $key
     * @param $data
     */
    public function setCache($key, $data)
    {
        return memcache_set($this->mc, $key, $data, 0, 30*60);
    }

    /**
     * @param $key
     */
    public function getCache($key)
    {
        return memcache_get($this->mc, $key);
    }

}
