<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 16:44:38
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 16:44:57
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;


use Binghe\Wechat\Core\AuthorizerOption;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizerOptionServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['option'] = function ($pimple) {
            return new AuthorizerOption(
                $pimple['config']['component_app_id'],
                $pimple['component_access_token']
            );
        };
    }
}