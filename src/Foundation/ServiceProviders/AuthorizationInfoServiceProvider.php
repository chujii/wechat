<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 15:56:53
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 15:57:30
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;


use Binghe\Wechat\Core\AuthorizationInfo;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizationInfoServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['authorization_info'] = function ($pimple) {
            return new AuthorizationInfo();
        };
    }
}