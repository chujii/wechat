<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 15:59:34
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 18:03:52
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;


use Binghe\Wechat\Core\AuthorizerAccessToken;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizerAccessTokenServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['authorizer_access_token'] = function ($pimple) {
            return new AuthorizerAccessToken(
                $pimple['config']['component_app_id'],
                $pimple['config']['app_id'],
                $pimple['authorizer_refresh_token'],
                $pimple['component_access_token'],
                $pimple['cache']
            );
        };
    }
}