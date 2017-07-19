<?php
/**
 * @Author: binghe
 * @Date:   2017-07-13 14:46:55
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-07-13 14:58:29
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;


use Binghe\Wechat\Oauth\OauthLoginPage;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class UserOauthServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['user_login'] = function ($pimple) {
            return new OauthLoginPage(
                $pimple['config']['component_app_id'],
                $pimple['config']['user_oauth']['app_id'],
                $pimple['config']['user_oauth']['scope'],
                $pimple['config']['user_oauth']['state'],
                $pimple['config']['user_oauth']['redirect_uri']
            );
        };
    }

}