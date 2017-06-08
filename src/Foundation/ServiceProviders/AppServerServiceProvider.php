<?php
/**
 * @Author: binghe
 * @Date:   2017-06-07 16:30:38
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 19:35:39
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
            $auth = new AppServer(
                $pimple['config']['token'],
                $pimple['app_server_handler'],
                $pimple['component_verify_ticket'],
                $pimple['authorization'],
                $pimple['authorizer_refresh_token'],
                $pimple['request']
            );

            $auth->debug($pimple['config']['debug']);

            $auth->setEncryptor($pimple['encryptor']);

            return $auth;
        };
    }
}