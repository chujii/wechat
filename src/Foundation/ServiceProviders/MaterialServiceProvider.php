<?php
/**
 * @Author: binghe
 * @Date:   2017-06-12 12:56:06
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-12 12:56:44
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;

use Binghe\Wechat\Material\Material;
use Binghe\Wechat\Material\Temporary;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class MaterialServiceProvider.
 */
class MaterialServiceProvider implements ServiceProviderInterface
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
        $pimple['material'] = function ($pimple) {
            return new Material($pimple['authorizer_access_token']);
        };

        $temporary = function ($pimple) {
            return new Temporary($pimple['authorizer_access_token']);
        };

        $pimple['material_temporary'] = $temporary;
        $pimple['material.temporary'] = $temporary;
    }
}