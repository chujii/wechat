<?php
/**
 * @Author: binghe
 * @Date:   2017-06-16 16:22:34
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-16 16:28:14
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;
use Binghe\Wechat\Encryption\Encryptor;
use Binghe\Wechat\Server\WechatServer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
/**
* app server
*/
class WechatServerServiceProvider implements ServiceproviderInterface
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

        $pimple['wechat_server'] = function ($pimple) {
            $auth = new WechatServer(
                $pimple['config']['token'],
                $pimple['request']
            );

            $auth->debug($pimple['config']['debug']);

            $auth->setEncryptor($pimple['encryptor']);

            return $auth;
        };
    }
}