<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 16:19:21
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 18:42:28
 */
namespace Binghe\Wechat\Contracts;

use Binghe\Wechat\Core\Authorization;
use Binghe\Wechat\Core\ComponentVerifyTicket;


/**
 * AuthPushContract.php
 */
interface AppServerHandlerContract
{
    /**
     * handle component verify ticket
     *
     * @param                       $message
     * @param ComponentVerifyTicket $componentVerifyTicket
     *
     * @return mixed
     */

    public function componentVerifyTicket($message, ComponentVerifyTicket $componentVerifyTicket);

    /**
     * handle authorized
     *
     * @param               $message
     * @param Authorization $authorization
     *
     * @return mixed
     */

    public function authorized($message, Authorization $authorization);

    /**
     * handle unauthorized
     *
     * @param $message
     *
     * @return mixed
     */
    public function unauthorized($message, AuthorizerRefreshTokenContract $authorizerRefreshToken);

    /**
     *
     * handle updateauthorized
     *
     * @param               $message
     * @param Authorization $authorization
     *
     * @return mixed
     */

    public function updateauthorized($message , Authorization $authorization);

}