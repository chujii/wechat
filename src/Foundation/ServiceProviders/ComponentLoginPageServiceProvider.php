<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 11:00:09
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 11:00:49
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;


use Binghe\Wechat\Core\ComponentLoginPage;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ComponentLoginPageServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['login'] = function ($pimple) {
            return new ComponentLoginPage(
                $pimple['config']['component_app_id'],
                $pimple['pre_auth_code'],
                $pimple['config']['redirect_uri']
            );
        };
    }

}