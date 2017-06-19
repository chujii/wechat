<?php
/**
 * @Author: binghe
 * @Date:   2017-06-07 10:36:14
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-17 11:35:29
 */
namespace Binghe\Wechat\Server;
use Binghe\Wechat\Core\Exceptions\FaultException;
use Binghe\Wechat\Core\Exceptions\InvalidArgumentException;
use Binghe\Wechat\Core\Exceptions\RuntimeException;
use Binghe\Wechat\Core\Exceptions\BadRequestException;
use Binghe\Wechat\Encryption\Encryptor;
use Binghe\Wechat\Support\Collection;
use Binghe\Wechat\Support\Log;
use Binghe\Wechat\Support\XML;
use Binghe\Wechat\Message\AbstractMessage;
use Binghe\Wechat\Message\Raw as RawMessage;
use Binghe\Wechat\Message\Text;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
*  Base server
*/
class BaseServer
{
    const SUCCESS_EMPTY_RESPONSE='success';
    /**
     * @var bool
     */
    protected $debug = false;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var string
     */
    protected $token;
    /**
     * @var Encryptor
     */
    protected $encryptor;

    /**
     * Constructor.
     *
     * @param string  $token
     * @param Request $request
     */
    public function __construct($token, Request $request = null)
    {
        $this->token = $token;
        $this->request = $request ?: Request::createFromGlobals();
    }
    public function debug($debug = true)
    {
        $this->debug = $debug;
    }
     /**
     * Validation request params.
     *
     * @param string $token
     *
     * @throws FaultException
     */
    public function validate($token)
    {
        $params = [
            $token,
            $this->request->get('timestamp'),
            $this->request->get('nonce'),
        ];

        if (!$this->debug && $this->request->get('signature') !== $this->signature($params)) {
            throw new FaultException('Invalid request signature.', 400);
        }
    }
    /**
     * Request getter.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Request setter.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }
    /**
     * Set Encryptor.
     *
     * @param Encryptor $encryptor
     *
     * @return BaseServer
     */
    public function setEncryptor(Encryptor $encryptor)
    {
        $this->encryptor = $encryptor;

        return $this;
    }

    /**
     * Return the encryptor instance.
     *
     * @return Encryptor
     */
    public function getEncryptor()
    {
        return $this->encryptor;
    }
    /**
     * Build response.
     *
     * @param $to
     * @param $from
     * @param mixed $message
     *
     * @return string
     *
     * @throws \Binghe\Wechat\Core\Exceptions\InvalidArgumentException
     */
    protected function buildResponse($to, $from, $message)
    {
        if (empty($message) || $message === self::SUCCESS_EMPTY_RESPONSE) {
            return self::SUCCESS_EMPTY_RESPONSE;
        }

        if ($message instanceof RawMessage) {
            return $message->get('content', self::SUCCESS_EMPTY_RESPONSE);
        }

        if (is_string($message) || is_numeric($message)) {
            $message = new Text(['content' => $message]);
        }

        if (!$this->isMessage($message)) {
            $messageType = gettype($message);
            throw new InvalidArgumentException("Invalid Message type .'{$messageType}'");
        }

        $response = $this->buildReply($to, $from, $message);
        Log::debug($response);
        if ($this->isSafeMode()) {
            Log::debug('Message safe mode is enable.');
            $response = $this->encryptor->encryptMsg(
                $response,
                $this->request->get('nonce'),
                $this->request->get('timestamp')
            );
        }

        return $response;
    }
     /**
     * Whether response is message.
     *
     * @param mixed $message
     *
     * @return bool
     */
    protected function isMessage($message)
    {
        if (is_array($message)) {
            foreach ($message as $element) {
                if (!is_subclass_of($element, AbstractMessage::class)) {
                    return false;
                }
            }

            return true;
        }

        return is_subclass_of($message, AbstractMessage::class);
    }
    /**
     * Get request message.
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function getMessage()
    {
        $message = $this->parseMessageFromRequest($this->request->getContent(false));

        if (!is_array($message) || empty($message)) {
            throw new BadRequestException('Invalid request.');
        }

        return $message;
    }
    

    /**
     * Build reply XML.
     *
     * @param string          $to
     * @param string          $from
     * @param AbstractMessage $message
     *
     * @return string
     */
    protected function buildReply($to, $from, $message)
    {
        $base = [
            'ToUserName' => $to,
            'FromUserName' => $from,
            'CreateTime' => time(),
            'MsgType' => is_array($message) ? current($message)->getType() : $message->getType(),
        ];

        $transformer = new Transformer();

        return XML::build(array_merge($base, $transformer->transform($message)));
    }

    /**
     * Get signature.
     *
     * @param array $request
     *
     * @return string
     */
    protected function signature($request)
    {
        sort($request, SORT_STRING);

        return sha1(implode($request));
    }

    /**
     * Parse message array from raw php input.
     *
     * @param string|resource $content
     *
     * @throws \Binghe\Wechat\Core\Exceptions\RuntimeException
     * @throws \Binghe\Wechat\Encryption\EncryptionException
     *
     * @return array
     */
    protected function parseMessageFromRequest($content)
    {
        $content = strval($content);

        $arrayable = json_decode($content, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $arrayable;
        }

        if ($this->isSafeMode()) {
            if (!$this->encryptor) {
                throw new RuntimeException('Safe mode Encryptor is necessary, please use BaseServer::setEncryptor(Encryptor $encryptor) set the encryptor instance.');
            }

            $message = $this->encryptor->decryptMsg(
                $this->request->get('msg_signature'),
                $this->request->get('nonce'),
                $this->request->get('timestamp'),
                $content
            );
        } else {
            $message = XML::parse($content);
        }

        return $message;
    }

    /**
     * Check the request message safe mode.
     *
     * @return bool
     */
    private function isSafeMode()
    {
        return $this->request->get('encrypt_type') && $this->request->get('encrypt_type') === 'aes';
    }

}