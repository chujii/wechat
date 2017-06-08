<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 10:42:27
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 10:43:28
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;
use Binghe\Wechat\Core\ComponentAccessToken;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ComponentAccessTokenServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['component_access_token'] = function ($pimple) {
            return new ComponentAccessToken(
                $pimple['config']['component_app_id'],
                $pimple['config']['component_app_secret'],
                $pimple['component_verify_ticket'],
                $pimple['cache']
            );
        };
    }
}