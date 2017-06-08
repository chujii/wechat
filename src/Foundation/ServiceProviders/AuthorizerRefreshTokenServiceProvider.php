<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 16:00:39
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 16:01:20
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;

use Binghe\Wechat\Core\AuthorizerRefreshToken;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthorizerRefreshTokenDefaultProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['authorizer_refresh_token'] = function ($pimple) {
            return new AuthorizerRefreshToken(
                $pimple['cache']
            );
        };
    }
}