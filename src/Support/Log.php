<?php
/**
 * @Author: binghe
 * @Date:   2017-06-01 15:16:42
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-02 10:49:44
 */
namespace Binghe\Wechat\Support;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
/**
* 日志
*/
class Log 
{
    /**
     * logger
     * @var
     */
    protected static $logger;

    /**
     * Return the logger instance.
     *
     * @return \Psr\Log\LoggerInterface
     */
    public static function getLogger()
    {
        return self::$logger ?: self::$logger = self::createDefaultLogger();
    }

    /**
     * Make a default log instance.
     *
     * @return \Monolog\Logger
     */
    private static function createDefaultLogger()
    {
        $log = new Logger('BingheWeChat');
        if(defined('BINHG_MONOLOG_PATH') && BINGHE_MONOLOG_PATH)
        {
            if (defined('PHPUNIT_RUNNING')) {
            $log->pushHandler(new NullHandler());
            } else {
                $log->pushHandler(new ErrorLogHandler());
            }
        }
        else
        {
            $streamHandler = new StreamHandler(BINGHE_MONOLOG_PATH,Logger::DEBUG);
            $log->pushHandler($streamHandler);
        }
        

        return $log;
    }
    /**
     * Forward call.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        return forward_static_call_array([self::getLogger(), $method], $args);
    }
}