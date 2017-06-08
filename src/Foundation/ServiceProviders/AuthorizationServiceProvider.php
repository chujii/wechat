<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 15:52:38
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 15:54:36
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;
use Binghe\Wechat\Core\Authorization;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizationServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['authorization'] = function ($pimple) {
            return new Authorization(
                $pimple['config']['component_app_id'],
                $pimple['component_access_token'],
                $pimple['authorizer_access_token'],
                $pimple['authorizer_refresh_token'],
                $pimple['authorization_info'],
                $pimple['cache']
            );
        };
    }

}