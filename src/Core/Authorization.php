<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 13:36:41
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 13:44:39
 */
namespace Binghe\Wechat\Core;
use Binghe\Wechat\Support\Log;
use Binghe\Wechat\Core\Exceptions\HttpException;
use Binghe\Wechat\Traits\CacheTrait;
use Binghe\Wechat\Traits\HttpTrait;
use Doctrine\Common\Cache\Cache;

class Authorization
{
    use HttpTrait,CacheTrait;
    /**
     * api
     */
    const API_QUERY_AUTH = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=';

    const AUTHORIZATION_INFO_CACHE_PREFIX = 'binghewechat.core.authorization_info.';
    /**
     * component app id
     * @var
     */

    protected $componentAppId;

    /**
     * component access token
     *
     * @var ComponentAccessToken
     */
    protected $componentAccessToken;
    /**
     * authorization code
     *
     * @var
     */
    protected $authorizationCode;
    /**
     *
     * authorizer refresh token
     *
     * @var AuthorizerRefreshTokenContract
     */
    protected $authorizerRefreshToken;


    /**
     *
     * authorizer access token
     *
     * @var AuthorizerAccessToken
     */

    protected $authorizerAccessToken;

    /**
     * authorization info
     * @var AuthorizationInfo
     */
    protected $authorizationInfo;
    public function __construct($componentAppId, ComponentAccessToken $componentAccessToken, AuthorizerAccessToken $authorizerAccessToken, AuthorizerRefreshTokenContract $authorizerRefreshToken, AuthorizationInfo $authorizationInfo, Cache $cache = null)
    {
        $this->componentAppId         = $componentAppId;
        $this->componentAccessToken   = $componentAccessToken;
        $this->authorizerRefreshToken = $authorizerRefreshToken;
        $this->authorizerAccessToken  = $authorizerAccessToken;
        $this->authorizationInfo      = $authorizationInfo;
        $this->cache                  = $cache;

        $this->setCacheKeyField('componentAppId');
        $this->setPrefix(static::AUTHORIZATION_INFO_CACHE_PREFIX);
    }

    /**
     * get authorization info
     *
     * @return $this
     */
    public function getAuthorizationInfo()
    {
        $authorizationInfo = $this->getAuthorizationInfoFromServer();
        Log::debug('Authorization info:', $authorizationInfo);
        //save refresh token
        $this->authorizerRefreshToken->setRefreshToken($authorizationInfo['authorizer_appid'], $authorizationInfo['authorizer_refresh_token']);
        //save access token
        $this->authorizerAccessToken->setAuthorizerAppId($authorizationInfo['authorizer_appid'])->setToken($authorizationInfo['authorizer_access_token'], $authorizationInfo['expires_in']);

        return $this->authorizationInfo->setAuthorizationInfo($authorizationInfo);
    }

    /**
     * get authorization info from server
     *
     * @return mixed
     * @throws HttpException
     */

    protected function getAuthorizationInfoFromServer()
    {
        $http = $this->getHttp();

        $params = [
            'json' => [
                'component_appid'    => $this->componentAppId,
                'authorization_code' => $this->authorizationCode,
            ],
        ];

        $authorizationInfo = $http->parseJSON($http->request(self::API_QUERY_AUTH . $this->componentAccessToken->getToken(), 'POST', $params));

        if (!isset($authorizationInfo['authorization_info']) || empty($authorizationInfo['authorization_info'])) {
            throw new HttpException('Request Authorization info fail. response: ' . json_encode($authorizationInfo, JSON_UNESCAPED_UNICODE));
        }

        return $authorizationInfo['authorization_info'];
    }

    /**
     * set authorization code
     *
     * @param $authorizationCode
     *
     * @return $this
     */
    public function setAuthorizationCode($authorizationCode)
    {
        Log::debug('Set authorization code:', [$authorizationCode]);
        $this->authorizationCode = $authorizationCode;
        return $this;
    }
}