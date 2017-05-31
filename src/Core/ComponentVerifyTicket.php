<?php
/**
 * @Author: binghe
 * @Date:   2017-05-31 14:24:24
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-05-31 16:43:31
 */
namespace Binghe\Wechat\Core;
use Binghe\Wechat\Traits\CacheTrait;
class ComponentVerifyTicket
{
    use CacheTrait;
    /**
     *
     * get verify ticket
     *
     * @return string
     */
    public function getVerifyTicket()
    {
        return 'test ticket';
    }
}