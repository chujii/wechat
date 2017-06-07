<?php
/**
 * @Author: binghe
 * @Date:   2017-06-06 17:47:05
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-07 17:29:51
 */
namespace Binghe\Wechat\Server;
use Binghe\Wechat\Core\ComponentVerifyTicket;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimple\Container;
class AppServer extends BaseServer
{
    protected $pimple;
    /**
     * component verify ticket
     *
     * @var ComponentVerifyTicket
     */
    public function __construct(Container $pimple)
    {
        $this->pimple=$pimple;
        parent::__construct($this->pimple['config']['token'],$this->pimple['request']);
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
        }
    }
    /**
     * save component_verify_ticket
     */
    private function componentVerifyTicket($message)
    {
        $componetVerifyTicket=$this->pimple['component_verify_ticket'];
        $componetVerifyTicket->setVerifyTicket($message['component_verify_ticket']);
    }
}