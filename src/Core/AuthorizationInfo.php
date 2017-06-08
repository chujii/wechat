<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 14:41:56
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 14:42:21
 */
namespace Binghe\Wechat\Core;


class AuthorizationInfo
{
    /**
     *
     * 公众号授权信息
     * @var array
     */
    protected $authorizationInfo = [];

    /**
     * 设置公众号授权信心
     *
     * @param $authInfo
     *
     * @return $this
     */
    public function setAuthorizationInfo($authorizationInfo)
    {
        $this->authorizationInfo = $authorizationInfo;
        return $this;
    }

    /**
     * 获取公众号授权信息字段
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return isset($this->authorizationInfo[$name]) ? $this->authorizationInfo[$name] : null;
    }

}