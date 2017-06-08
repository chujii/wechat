<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 16:43:49
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 16:44:08
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;


use Binghe\Wechat\Core\AuthorizerInfo;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizerInfoServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['authorizer_info'] = function ($pimple) {
            return new AuthorizerInfo();
        };
    }

}