<?php
/**
 * @Author: binghe
 * @Date:   2017-06-19 11:59:11
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-19 13:24:15
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;
use Binghe\Wechat\Encryption\Encryptor;
use Binghe\Wechat\Server\PublishServer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
/**
* app server
*/
class PublishServerServiceProvider implements ServiceproviderInterface
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

        $pimple['publish_server'] = function ($pimple) {
            $auth = new PublishServer(
                $pimple,
                $pimple['request']
            );

            $auth->debug($pimple['config']['debug']);

            $auth->setEncryptor($pimple['encryptor']);

            return $auth;
        };
    }
}