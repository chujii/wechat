<?php
/**
 * @Author: binghe
 * @Date:   2017-06-07 16:30:38
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-07 16:31:54
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;

use Binghe\Wechat\Server\AppServer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
/**
* app server
*/
class AppServerServiceProvider implements ServiceproviderInterface
{
    
    public function register(Container $pimple)
    {
        $pimple['component_verify_ticket'] = function ($pimple) {
            return new AppServer(
                    $pimple
                );
        };
    }
}