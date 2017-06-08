<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 16:38:38
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 18:13:17
 */
namespace Binghe\Wechat\Core;


use Binghe\Wechat\Traits\HttpTrait;
use EasyWeChat\Core\Exceptions\HttpException;

class Authorizer
{

    use HttpTrait;

    /**
     * api
     */
    const API_GET_AUTHORIZER_INFO = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token=';
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
     * 公众账号基本信息
     * @var
     */
    protected $authorizerInfo;

    public function __construct($componentAppId, ComponentAccessToken $componentAccessToken, AuthorizerInfo $authorizerInfo)
    {
        $this->componentAppId       = $componentAppId;
        $this->componentAccessToken = $componentAccessToken;
        $this->authorizerInfo       = $authorizerInfo;
    }

    /**
     *
     * @param $authorizerAppId
     *
     * @return $this
     */
    public function getAuthorizerInfo($authorizerAppId)
    {
        $authorizerInfo = $this->getAuthorizerInfoFromServer($authorizerAppId);
        return $this->authorizerInfo->setAuthorizerInfo($authorizerInfo);
    }

    /**
     * get from server
     * @return mixed
     * @throws HttpException
     */
    protected function getAuthorizerInfoFromServer($authorizerAppId)
    {
        $params = [
            'json' => [
                'component_appid'  => $this->componentAppId,
                'authorizer_appid' => $authorizerAppId,
            ],
        ];

        $http = $this->getHttp();

        $authorizerInfo = $http->parseJSON($http->request(self::API_GET_AUTHORIZER_INFO . $this->componentAccessToken->getToken(), 'POST', $params));

        if (!isset($authorizerInfo['authorizer_info']) || empty($authorizerInfo['authorizer_info'])) {
            throw new HttpException('Request Authorizer Info fail. response: ' . json_encode($authorizerInfo, JSON_UNESCAPED_UNICODE));
        }

        return $authorizerInfo['authorizer_info'];

    }


}