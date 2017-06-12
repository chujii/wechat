<?php
/**
 * @Author: binghe
 * @Date:   2017-06-12 13:45:58
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-12 13:46:22
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;

use Binghe\Wechat\User\Group;
use Binghe\Wechat\User\Tag;
use Binghe\Wechat\User\User;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class UserServiceProvider.
 */
class UserServiceProvider implements ServiceProviderInterface
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
        $pimple['user'] = function ($pimple) {
            return new User($pimple['authorizer_access_token']);
        };

        $group = function ($pimple) {
            return new Group($pimple['authorizer_access_token']);
        };

        $tag = function ($pimple) {
            return new Tag($pimple['authorizer_access_token']);
        };

        $pimple['user_group'] = $group;
        $pimple['user.group'] = $group;

        $pimple['user_tag'] = $tag;
        $pimple['user.tag'] = $tag;
    }
}