<?php
/**
 * @Author: binghe
 * @Date:   2017-06-19 11:37:40
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-22 13:50:39
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;

use Binghe\Wechat\Staff\Session;
use Binghe\Wechat\Staff\Staff;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class StaffServiceProvider.
 */
class StaffServiceProvider implements ServiceProviderInterface
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
        $pimple['staff'] = function ($pimple) {
            return new Staff($pimple['authorizer_access_token'],$pimple['language']);
        };

        $pimple['staff_session'] = $pimple['staff.session'] = function ($pimple) {
            return new Session($pimple['authorizer_access_token'],$pimple['language']);
        };
    }
}