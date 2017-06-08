<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 14:21:07
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 14:23:41
 */
namespace Binghe\Wechat\Core;
use Binghe\Wechat\Contracts\AuthorizerRefreshTokenContract;
use Binghe\Wechat\Support\Log;
use Binghe\Wechat\Traits\CacheTrait;
use Doctrine\Common\Cache\Cache;
class AuthorizerRefreshToken implements AuthorizerRefreshTokenContract
{
    use CacheTrait;

    /**
     * app id
     *
     * @var string
     */
    protected $authorizerAppId = '';


    /**
     *  cache key prefix
     */

    const AUTHORIZER_REFRESH_TOKEN_CACHE_PREFIX = 'binghewechat.core.refresh_token.';

    public function __construct(Cache $cache = null)
    {
        $this->cache = $cache;

        $this->setCacheKeyField('authorizerAppId');
        $this->setPrefix(static::AUTHORIZER_REFRESH_TOKEN_CACHE_PREFIX);
    }

    /**
     *
     * get refresh token
     *
     * @param $authorizerAppId
     *
     * @return mixed|string
     */
    public function getRefreshToken($authorizerAppId)
    {
        $this->setAuthorizerAppId($authorizerAppId);
        $cacheKey               = $this->getCacheKey();
        $authorizerRefreshToken = $this->getCache()->fetch($cacheKey);
        Log::debug('Get refresh token from cache:', [$authorizerAppId, $authorizerRefreshToken]);
        return $authorizerRefreshToken;
    }

    /**
     * set refresh token
     *
     * @param $authorizerAppId
     * @param $authorizerRefreshToken
     */

    public function setRefreshToken($authorizerAppId, $authorizerRefreshToken)
    {
        $this->setAuthorizerAppId($authorizerAppId);
        $cacheKey = $this->getCacheKey();
        $this->getCache()->save($cacheKey, $authorizerRefreshToken);
        Log::debug('Set refresh token:', [$authorizerAppId, $authorizerRefreshToken]);
    }

    /**
     *
     * remove refresh token
     *
     * @param $authorizerAppId
     */
    public function removeRefreshToken($authorizerAppId)
    {
        $this->setAuthorizerAppId($authorizerAppId);
        $cacheKey = $this->getCacheKey();
        $this->getCache()->delete($cacheKey);
        Log::debug('Remove refresh token:', [$authorizerAppId]);
    }

    /**
     * set authorizer app id
     *
     * @param $authorizerAppId
     */

    private function setAuthorizerAppId($authorizerAppId)
    {
        $this->authorizerAppId = $authorizerAppId;
    }
}