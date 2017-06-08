<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 14:18:38
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 14:19:10
 */
namespace Binghe\Wechat\Contracts;
/**
 * AuthorizerRefreshTokenContract.php
 */
interface AuthorizerRefreshTokenContract
{
    /**
     * get refresh token by app id
     * @param $authorizerAppId
     *
     * @return mixed
     */
    public function getRefreshToken($authorizerAppId);

    /**
     *
     * set refresh token by app id
     * @param $authorizerAppId
     * @param $authorizerRefreshToken
     *
     * @return mixed
     */

    public function setRefreshToken($authorizerAppId, $authorizerRefreshToken);

    /**
     * remove refresh token by app id
     * @param $authorizerAppId
     *
     * @return mixed
     */
    public function removeRefreshToken($authorizerAppId);
}