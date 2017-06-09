<?php
/**
 * @Author: binghe
 * @Date:   2017-06-09 14:55:59
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-09 14:56:48
 */
/**
* 
*/
namespace Binghe\Wechat\Foundation\ServiceProviders;

use Binghe\Wechat\Menu\Menu;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class MenuServiceProvider.
 */
class MenuServiceProvider implements ServiceProviderInterface
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
        $pimple['menu'] = function ($pimple) {
            return new Menu($pimple['authorizer_access_token']);
        };
    }
}