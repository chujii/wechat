<?php
/**
 * @Author: binghe
 * @Date:   2017-06-06 17:47:05
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 16:25:34
 */
namespace Binghe\Wechat\Server;
use Binghe\Wechat\Core\ComponentVerifyTicket;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimple\Container;
class AppServer extends BaseServer
{
    /**
     * authorize handler
     *
     * @var AuthorizeHandlerContract
     */
    protected $appServerHandler;
    /**
     * component verify ticket
     *
     * @var ComponentVerifyTicket
     */
    protected $componentVerifyTicket;

    /**
     * authorization
     * @var Authorization
     */
    protected $authorization;

    /**
     *
     * authorizer Refresh Token
     *
     * @var
     */
    protected $authorizerRefreshToken;

    public function __construct($token, AppServerHandlerContract $appServerHandler, ComponentVerifyTicket $componentVerifyTicket, Authorization $authorization, AuthorizerRefreshTokenContract $authorizerRefreshToken, Request $request = null)
    {
        parent::__construct($token, $request);

        $this->appServerHandler       = $appServerHandler;
        $this->componentVerifyTicket  = $componentVerifyTicket;
        $this->authorization      = $authorization;
        $this->authorizerRefreshToken = $authorizerRefreshToken;
    }

    /**
     * handle authorize event
     *
     * @return Response
     */

    public function handle()
    {

        $this->validate($this->token);

        $this->handleRequest();

        return new Response(static::SUCCESS_EMPTY_RESPONSE);
    }

    /**
     *
     * handle publish event
     *
     */
    public function handleRequest()
    {
        $message = $this->getMessage();
        switch ($message['InfoType']) {
            case 'component_verify_ticket':
                $this->authorizeHandler->componentVerifyTicket($message, $this->componentVerifyTicket);
                break;
            case 'authorized':
                $this->authorizeHandler->authorized($message, $this->authorization);
                break;
            case 'unauthorized':
                $this->authorizeHandler->unauthorized($message, $this->authorizerRefreshToken);
                break;
            case 'updateauthorized':
                $this->authorizeHandler->updateauthorized($message, $this->authorization);
                break;
        }
    }
}