<?php
/**
 * @Author: binghe
 * @Date:   2017-05-31 13:52:59
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-05 16:49:06
 */
namespace Binghe\Wechat\Foundation;
use Binghe\Wechat\Support\Log;
use Pimple\Container;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
/**
* 
*/
class Application extends Container
{
    protected $providers = [
    ServiceProviders\ComponentVerifyTicketServiceProvider::class
    ];
    public function __construct($config)
    {
        parent::__construct();
        $this['config'] = function () use ($config) {
            return new Config($config);
        };
        if ($this['config']['debug']) {
            error_reporting(E_ALL);
        }
        $this->registerBase();
        $this->registerProviders();
        $this->initializeLogger();
    }
    /**
     * register base provider
     */
    public function registerBase()
    {
        $this['request'] = function () {
            return Request::createFromGlobals();
        };
        if (!empty($this['config']['cache']) && $this['config']['cache'] instanceof CacheInterface) {
            $this['cache'] = $this['config']['cache'];
        } else {
            $this['cache'] = function () {
                return new FilesystemCache(sys_get_temp_dir());
            };
        }
    }
    /**
     * Register providers.
     * @return [type] [description]
     */
    private function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider);
        }
    }
    /**
     * Initialize logger.
     */
    private function initializeLogger()
    {
        if (Log::hasLogger()) {
            return;
        }

        $logger = new Logger('BingheWeChat');

        if (!$this['config']['debug'] || defined('PHPUNIT_RUNNING')) {
            $logger->pushHandler(new NullHandler());
        } elseif ($this['config']['log.handler'] instanceof HandlerInterface) {
            $logger->pushHandler($this['config']['log.handler']);
        } elseif ($logFile = $this['config']['log.file']) {

            $logger->pushHandler(new StreamHandler($logFile, $this['config']->get('log.level', Logger::WARNING)));
        }

        Log::setLogger($logger);
    }
    /**
     * Add a provider.
     *
     * @param string $provider
     *
     * @return Application
     */
    public function addProvider($provider)
    {
        array_push($this->providers, $provider);

        return $this;
    }

    /**
     * Set providers.
     *
     * @param array $providers
     */
    public function setProviders(array $providers)
    {
        $this->providers = [];

        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }
    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed  $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }
    /**
     * Magic call.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        if (is_callable([$this['fundamental.api'], $method])) {
            return call_user_func_array([$this['fundamental.api'], $method], $args);
        }

        throw new \Exception("Call to undefined method {$method}()");
    }
}