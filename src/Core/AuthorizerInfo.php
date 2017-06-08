<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 16:39:27
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 16:39:44
 */
namespace Binghe\Wechat\Core;


class AuthorizerInfo
{
    /**
     * 获取授权方的公众号帐号基本信息
     * @var
     */

    protected $authorizerInfo = [];

    /**
     * 设置公众账号基本信息
     *
     * @param $authorizerInfo
     *
     * @return $this
     */
    public function setAuthorizerInfo($authorizerInfo)
    {
        $this->authorizerInfo = $authorizerInfo;
        return $this;
    }

    /**
     *
     * 获取公众号信息字段
     *
     * @param $name
     *
     * @return null
     */
    public function __get($name)
    {
        return isset($this->authorizerInfo[$name]) ? $this->authorizerInfo[$name] : null;
    }

}