<?php
/**
 * @Author: binghe
 * @Date:   2017-07-13 16:30:31
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-07-13 16:40:24
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;


use Binghe\Wechat\Oauth\UserAuthorization;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizationInfoServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['user_authorization'] = function ($pimple) {
            return new UserAuthorization(
                    $pimple['config']['app_id'],
                    $pimple['config']['component_app_id'],
                    $pimple['component_access_token'], 
                    $pimple['language']
                );
        };
    }
}