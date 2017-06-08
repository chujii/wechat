<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 16:42:05
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 16:43:22
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;


use Binghe\Wechat\Core\Authorizer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['authorizer'] = function ($pimple) {
            return new Authorizer(
                $pimple['config']['component_app_id'],
                $pimple['component_access_token'],
                $pimple['authorizer_info']
            );
        };

    }
}