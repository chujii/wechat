<?php
/**
 * @Author: binghe
 * @Date:   2017-06-02 14:43:34
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-02 16:37:19
 */
namespace Binghe\Wechat\Foundation\ServiceProviders;

use Binghe\Wechat\Core\ComponentVerifyTicket;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ComponentVerifyTicketServiceProvider implements ServiceproviderInterface
{
    
    public function register(Container $pimple)
    {
        $pimple['component_verify_ticket'] = function ($pimple) {
            return new ComponentVerifyTicket(
                    $pimple['config']['component_app_id']
                );
        };
    }
}