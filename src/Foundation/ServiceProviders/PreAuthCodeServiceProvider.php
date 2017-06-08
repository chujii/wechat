<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 10:57:42
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 10:58:02
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;


use Binghe\Wechat\Core\PreAuthCode;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class PreAuthCodeServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['pre_auth_code'] = function ($pimple) {
            return new PreAuthCode(
                $pimple['config']['component_app_id'],
                $pimple['component_access_token']
            );
        };
    }
}