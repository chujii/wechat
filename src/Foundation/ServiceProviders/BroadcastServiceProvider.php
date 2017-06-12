<?php
/**
 * @Author: binghe
 * @Date:   2017-06-12 14:55:42
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-12 14:56:02
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;

use Binghe\Wechat\Broadcast\Broadcast;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class BroadcastServiceProvider.
 */
class BroadcastServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['broadcast'] = function ($pimple) {
            return new Broadcast($pimple['authorizer_access_token']);
        };
    }
}