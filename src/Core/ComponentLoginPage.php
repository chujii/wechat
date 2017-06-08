<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 10:51:53
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 10:52:50
 */
namespace Binghe\Wechat\Core;


class ComponentLoginPage
{
    /**
     * component login page uri
     */
    const COMPONENT_LOGIN_PAGE_URI = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={COMPONENT_APPID}&pre_auth_code={PRE_AUTH_CODE}&redirect_uri={REDIRECT_URI}';

    /**
     * component app id
     * @var
     */
    protected $componentAppId;

    /**
     * pre auth code
     *
     * @var
     */
    protected $preAuthCode;
    /**
     * auth callback url
     * @var string
     */
    protected $redirectUri = '';

    public function __construct($componentAppId,PreAuthCode $preAuthCode, $redirectUri)
    {
        $this->componentAppId = $componentAppId;
        $this->preAuthCode    = $preAuthCode;
        $this->redirectUri    = $redirectUri;
    }

    /**
     *
     * get component login page uri
     *
     * @return mixed
     */

    public function getLoginPage()
    {
        return str_replace(
            [
                '{COMPONENT_APPID}',
                '{PRE_AUTH_CODE}',
                '{REDIRECT_URI}',
            ],
            [
                $this->componentAppId,
                $this->preAuthCode->getPreAuthCode(),
                urlencode($this->redirectUri),
            ],
            static::COMPONENT_LOGIN_PAGE_URI
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