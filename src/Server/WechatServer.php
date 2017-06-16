<?php
/**
 * @Author: binghe
 * @Date:   2017-06-06 17:48:56
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-16 16:12:17
 */
namespace Binghe\Wechat\Server;
use Binghe\Wechat\Core\ComponentVerifyTicket;

class WechatServer extends BaseServer
{
    const TEXT_MSG = 2;
    const IMAGE_MSG = 4;
    const VOICE_MSG = 8;
    const VIDEO_MSG = 16;
    const SHORT_VIDEO_MSG = 32;
    const LOCATION_MSG = 64;
    const LINK_MSG = 128;
    const DEVICE_EVENT_MSG = 256;
    const DEVICE_TEXT_MSG = 512;
    const EVENT_MSG = 1048576;
    const ALL_MSG = 1049598;
    /**
     * @var string|callable
     */
    protected $messageHandler;

    /**
     * @var int
     */
    protected $messageFilter;

    /**
     * @var array
     */
    protected $messageTypeMapping = [
        'text' => 2,
        'image' => 4,
        'voice' => 8,
        'video' => 16,
        'shortvideo' => 32,
        'location' => 64,
        'link' => 128,
        'device_event' => 256,
        'device_text' => 512,
        'event' => 1048576,
    ];

    public function __construct($token, Request $request = null)
    {
        parent::__construct($token, $request);

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
     * Add a event listener.
     *
     * @param callable $callback
     * @param int      $option
     *
     * @return Guard
     *
     * @throws InvalidArgumentException
     */
    public function setMessageHandler($callback = null, $option = self::ALL_MSG)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Argument #2 is not callable.');
        }

        $this->messageHandler = $callback;
        $this->messageFilter = $option;

        return $this;
    }
    /**
     * Return the message listener.
     *
     * @return string
     */
    public function getMessageHandler()
    {
        return $this->messageHandler;
    }
}