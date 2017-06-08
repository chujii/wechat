<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 10:00:54
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 10:40:42
 */
namespace Binghe\Wechat\Core;
use Binghe\Wechat\Support\Log;
use Binghe\Wechat\Traits\CacheTrait;
use Binghe\Wechat\Traits\HttpTrait;
use Binghe\Wechat\Core\Exceptions\HttpException;
use Doctrine\Common\Cache\Cache;
/**
* Component access token
*/
class ComponentAccessToken
{
    
    use CacheTrait,HttpTrait;
    /**
     * api
     */
    const API_COMPONENT_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';


    /**
     * cache key prefix
     *
     */
    const COMPONENT_ACCESS_TOKEN_CACHE_PREFIX = 'binghewechat.core.component_access_token.';

    /**
     * component app id
     * @var
     */

    protected $componentAppId;

    /**
     *
     * component app secret
     *
     * @var
     */

    protected $componentAppSecret;


    /**
     *
     * component verify ticket
     *
     * @var
     */

    protected $componentVerifyTicket;

    public function __construct($componentAppId, $componentAppSecret, ComponentVerifyTicket $componentVerifyTicket, Cache $cache = null)
    {
        $this->componentAppId        = $componentAppId;
        $this->componentAppSecret    = $componentAppSecret;
        $this->componentVerifyTicket = $componentVerifyTicket;
        $this->cache                 = $cache;

        $this->setPrefix(static::COMPONENT_ACCESS_TOKEN_CACHE_PREFIX);
        $this->setCacheKeyField('componentAppId');

    }

    /**
     * get token
     *
     * @param bool $forceRefresh
     *
     * @return mixed
     */

    public function getToken($forceRefresh = false)
    {
        $cacheKey = $this->getCacheKey();
        $cached   = $this->getCache()->fetch($cacheKey);

        if ($forceRefresh || empty($cached)) {
            $token = $this->getTokenFromServer();

            // XXX: T_T... 7200 - 1500
            $this->getCache()->save($cacheKey, $token['component_access_token'], $token['expires_in'] - 1500);
            Log::debug('Get component access token from server:', $token);
            return $token['component_access_token'];
        }
        Log::debug('Get component access token from cache:', [$cached]);
        return $cached;
    }

    /**
     * get token from server
     *
     * @return mixed
     * @throws HttpException
     */
    public function getTokenFromServer()
    {
        $params = [
            'json' => [
                'component_appid'         => $this->componentAppId,
                'component_appsecret'     => $this->componentAppSecret,
                'component_verify_ticket' => $this->componentVerifyTicket->getVerifyTicket(),
            ],
        ];

        $http = $this->getHttp();

        $token = $http->parseJSON($http->request(self::API_COMPONENT_TOKEN, 'POST', $params));

        if (empty($token['component_access_token'])) {
            throw new HttpException('Request Component AccessToken fail. response: ' . json_encode($token, JSON_UNESCAPED_UNICODE));
        }

        return $token;
    }
}