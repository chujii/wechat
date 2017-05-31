<?php
/**
 * @Author: binghe
 * @Date:   2017-05-31 14:31:08
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-05-31 14:32:57
 */
namespace Binghe\Wechat\Traits;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
/**
* 缓存
*/
trait CacheTrait
{
    /**
     * Cache.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Cache Key.
     *
     * @var cacheKey
     */
    protected $cacheKey;

    /**
     * Cache Key Field
     *
     * @var string
     */

    protected $cacheKeyField = '';


    /**
     * Cache key prefix.
     *
     * @var string
     */
    protected $prefix = '';


    /**
     * Set cache instance.
     *
     * @param \Doctrine\Common\Cache\Cache $cache
     *
     * @return AccessToken
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * Return the cache manager.
     *
     * @return \Doctrine\Common\Cache\Cache
     */
    public function getCache()
    {
        return $this->cache ?: $this->cache = new FilesystemCache(sys_get_temp_dir());
    }

    /**
     * Set the access token prefix.
     *
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Set access token cache key.
     *
     * @param string $cacheKey
     *
     * @return $this
     */
    public function setCacheKey($cacheKey)
    {
        $this->cacheKey = $cacheKey;

        return $this;
    }

    /**
     * Get access token cache key.
     *
     * @return string $this->cacheKey
     */
    public function getCacheKey()
    {
        if (is_null($this->cacheKey)) {
            return $this->prefix . $this->{$this->cacheKeyField};
        }

        return $this->cacheKey;
    }

    /**
     * @param $cacheKeyField
     *
     * @return $this
     */
    public function setCacheKeyField($cacheKeyField)
    {
        $this->cacheKeyField = $cacheKeyField;

        return $this;
    }
}