<?php
/**
 * @Author: binghe
 * @Date:   2017-07-13 14:36:58
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-07-13 16:28:24
 */
namespace Binghe\Wechat\Oauth;
use Binghe\Wechat\Core\Exceptions\HttpException;
use Binghe\Wechat\Core\ComponentAccessToken;
use Binghe\Wechat\Traits\HttpTrait;
use Binghe\Wechat\Support\Log;
use Binghe\Wechat\Support\Language;

/**
* user authrization
*/
class UserAuthorization 
{
    use HttpTrait;
    /**
     * api
     */
    const API_QUERY_AUTH = 'https://api.weixin.qq.com/sns/oauth2/component/access_token?appid={APPID}&code={CODE}&grant_type=authorization_code&component_appid={COMPONENT_APPID}&component_access_token={COMPONENT_ACCESS_TOKEN}';
    /**
     * app id
     */
    protected $appId;
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
     */
    protected $authorizationCode;
    /**
     * language
     * @var [type]
     */
    public $language;

    public function __construct($appId,$componentAppId,ComponentAccessToken $componentAccessToken,$language='zh_cn')
    {
        $this->appId=$appId;
        $this->componentAppId=$componentAppId;
        $this->componentAccessToken=$componentAccessToken;
        $this->language=$language;
    }
    /**
     * 得到授权信息
     * @return [type] [description]
     */
    public function getAuthorizationInfo()
    {
        return $this->getAuthorizationInfoFromServer();
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
        $authorizationInfo = $http->parseJSON($http->request($this->getUri()));
        $this->checkAndThrow($authorizationInfo);
        return $authorizationInfo;
    }
    /**
     * set authorization code
     *
     * @param $authorizationCode
     * @return $this
     */
    public function setAuthorizationCode($authorizationCode)
    {
        Log::debug('Set user authorization code:', [$authorizationCode]);
        $this->authorizationCode = $authorizationCode;
        return $this;
    }
    /**
     * get login page
     * @return string
     */
    protected function getUri()
    {
        return str_replace(
            [   
                '{APPID}',
                '{CODE}',
                '{COMPONENT_APPID}',
                'COMPONENT_ACCESS_TOKEN'
            ],
            [
                $this->appId,
                $this->authorizationCode,
                $this->componentAppId,
                $componentAccessToken->getToken()
            ],
            static::API_QUERY_AUTH
        );
    }
    /**
     * Check the array data errors, and Throw exception when the contents contains error.
     *
     * @param array $contents
     *
     * @throws \Binghe\Wechat\Core\Exceptions\HttpException
     */
    protected function checkAndThrow(array $contents)
    {
        if (isset($contents['errcode']) && 0 !== $contents['errcode']) {
            if (empty($contents['errmsg'])) {
                $contents['errmsg'] = 'Unknown';
            }
            $errMsg=Language::getMessage($contents['errcode'],$contents['errmsg'],$this->language);
            throw new HttpException($errMsg, $contents['errcode']);
        }
    }
}