<?php
/**
 * @Author: binghe
 * @Date:   2017-06-07 16:30:38
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-07 19:39:25
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;
use Binghe\Wechat\Encryption\Encryptor;
use Binghe\Wechat\Server\AppServer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
/**
* app server
*/
class AppServerServiceProvider implements ServiceproviderInterface
{
    
    public function register(Container $pimple)
    {
        $pimple['encryptor'] = function ($pimple){
            return new Encryptor(
                    $pimple['config']['component_app_id'],
                    $pimple['config']['token'],
                    $pimple['config']['aes_key']
                );
        };

        $pimple['app_server'] = function ($pimple) {
            $server = new AppServer(
                    $pimple
                );
            $server->debug($pimple['config']['debug']);
            $server->setEncryptor($pimple['encryptor']);
            return $server;
        };
    }
}