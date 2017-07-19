<?php
/**
 * @Author: binghe
 * @Date:   2017-07-13 13:31:41
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-07-13 14:46:02
 */
namespace Binghe\Wechat\Oauth;
/**
* user auth login
*/
class OauthLoginPage
{
    /**
     * get code uri
     */
    const OAUTH_LOGIN_PAGE_URI = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid={APPID}&redirect_uri={REDIRECT_URI}&response_type=code&scope={SCOPE}&state={STATE}&component_appid={COMPONENT_APPID}#wechat_redirect';
    /**
     * get access_token
     */
    
    /**
     *  appId
     * @var string
     */
    protected $appId;
    /**
     * redirect uri
     * @var string
     */
    protected $redirectUri;
    /**
     * scope : snsapi_base/snsapi_userinfo
     * @var string
     */
    protected $scope;
    /**
     * state remark
     * @var string
     */
    protected $state;
    /**
     * component app id
     * @var string
     */
    protected $componentAppId;

    public function __construct($componentAppId,$appId,$scope,$state,$redirectUri)
    {
        $this->appId=$appId;
        $this->redirectUri=$redirectUri;
        $this->scope=$scope;
        $this->state=$state;
        $this->componentAppId=$componentAppId;
    }

    /**
     * get login page
     * @return string
     */
    public function getLoginPage()
    {
        return str_replace(
            [   
                '{APPID}',
                '{REDIRECT_URI}',
                '{SCOPE}',
                '{STATE}',
                '{COMPONENT_APPID}'
            ],
            [
                $this->appId,
                urlencode($this->redirectUri),
                $this->scope,
                $this->state,
                $this->componentAppId
            ],
            static::OAUTH_LOGIN_PAGE_URI
        );
    }
    /**
     * set redirect uri
     *
     * @param $redirectUri
     *
     * @return $this
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
        return $this;
    }

}