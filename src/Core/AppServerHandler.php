<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 16:26:52
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 16:30:44
 */
namespace Binghe\Wechat\Core;


use Binghe\Wechat\Contracts\AuthorizeHandlerContract;
use Binghe\Wechat\Contracts\AuthorizerRefreshTokenContract;
use Binghe\Wechat\Support\Log;

class AppServerHandler implements AuthorizeHandlerContract
{

    public function componentVerifyTicket($message, ComponentVerifyTicket $componentVerifyTicket)
    {
        Log::debug('ComponentVerifyTicket event:', $message);
        $componentVerifyTicket->setVerifyTicket($message['ComponentVerifyTicket']);
    }

    public function authorized($message, Authorization $authorization)
    {
        Log::debug('Authorized event:', $message);
        $authorization->setAuthorizationCode($message['AuthorizationCode'])->getAuthorizationInfo();
    }

    public function unauthorized($message, AuthorizerRefreshTokenContract $authorizerRefreshToken)
    {
        Log::debug('Unauthorized event:', $message);
        $authorizerRefreshToken->removeRefreshToken($message['AuthorizerAppid']);
    }

    public function updateauthorized($message, Authorization $authorization)
    {
        Log::debug('Updateauthorized event:', $message);
        $authorization->setAuthorizationCode($message['AuthorizationCode'])->getAuthorizationInfo();
    }
}