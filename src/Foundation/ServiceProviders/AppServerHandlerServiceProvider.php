<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 16:28:36
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 16:31:03
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;


use Binghe\Wechat\Core\AuthorizeHandler;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AppServerHandlerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['app_server_handler'] = function ($pimple) {
            return new AppServerHandler();
        };
    }

}