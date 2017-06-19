<?php
/**
 * @Author: binghe
 * @Date:   2017-06-19 11:56:33
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-19 13:22:58
 */
namespace Binghe\Wechat\Server;
use Binghe\Wechat\Core\Exceptions\InvalidArgumentException;
use Binghe\Wechat\Support\Collection;
use Binghe\Wechat\Support\Log;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimple\Container;

class PublishServer extends BaseServer
{
    /**
     * Publish test app id
     */
    const PUBLISH_TEST_APP_ID = 'wx570bc396a51b8ff8';

    /**
     * Publish test query auth code prefix
     */

    const QUERY_AUTH_CODE_PREFIX = 'QUERY_AUTH_CODE:';

    /**
     * app id
     * @var
     */
    protected $appId;

    /**
     *
     * Container
     *
     * @var EasyWechatApplication
     */

    protected $app;
    public function __construct(Container $app, Request $request = null)
    {
        parent::__construct($app['config']['token'], $request);
        $this->appId = $app['config']['app_id'];
        $this->app   = $app;
    }

    /**
     * Handle and return response.
     *
     * @return Response
     *
     * @throws BadRequestException
     */
    public function serve()
    {
        Log::debug('Request received:', [
            'Method' => $this->request->getMethod(),
            'URI' => $this->request->getRequestUri(),
            'Query' => $this->request->getQueryString(),
            'Protocal' => $this->request->server->get('SERVER_PROTOCOL'),
            'Content' => $this->request->getContent(),
        ]);

        $this->validate($this->token);

        if ($str = $this->request->get('echostr')) {
            Log::debug("Output 'echostr' is '$str'.");

            return new Response($str);
        }

        $result = $this->handleRequest();

        $response = $this->buildResponse($result['to'], $result['from'], $result['response']);

        Log::debug('Server response created:', compact('response'));

        return new Response($response);
    }
    /**
     * Handle request.
     *
     * @return array
     *
     * @throws \EasyWeChat\Core\Exceptions\RuntimeException
     * @throws \EasyWeChat\Server\BadRequestException
     */
    protected function handleRequest()
    {
        $message = $this->getMessage();
        $response = $this->handlePublishMessage($message);
        return [
            'to'       => $message['FromUserName'],
            'from'     => $message['ToUserName'],
            'response' => $response,
        ];
    }

    /**
     * Handle publish message.
     *
     * @param $message
     *
     * @return string
     */
    protected function handlePublishMessage($message)
    {
        Log::debug('Publish Message:', $message);
        switch ($message['MsgType']) {
            case 'text':
                if ($message['Content'] == 'TESTCOMPONENT_MSG_TYPE_TEXT') {
                    return 'TESTCOMPONENT_MSG_TYPE_TEXT_callback';
                }

                if (strpos($message['Content'], static::QUERY_AUTH_CODE_PREFIX) === 0) {
                    list($foo, $queryAuthCode) = explode(':', $message['Content']);

                    $this->app->authorization->setAuthorizationCode($queryAuthCode)->getAuthorizationInfo();

                    $this->app->staff->message($queryAuthCode . '_from_api')->to($message['FromUserName'])->send();
                    return '';
                }
                break;
            case 'event':
                return $message['Event'] . 'from_callback';
                break;
        }
        return static::SUCCESS_EMPTY_RESPONSE;
    }
}