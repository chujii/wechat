<?php
/**
 * @Author: binghe
 * @Date:   2017-05-31 14:24:24
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 10:24:23
 */
namespace Binghe\Wechat\Core;
use Binghe\Wechat\Traits\CacheTrait;
use Binghe\Wechat\Support\Log;
class ComponentVerifyTicket
{
    use CacheTrait;
    /**
     * component app id
     * @var [type]
     */
    protected $componentAppId;
    /**
     * verify ticket
     * @var string
     */
    protected $verifyTicket = '';
    /**
     * cache key prefix
     */
    const COMPONENT_VERIFY_TICKET_CACHE_PREFIX='binghewechat.core.verify_ticket.';

    public function __construct($componentAppId,Cache $cache=null)
    {
        $this->componentAppId = $componentAppId;
        $this->cache          = $cache;

        $this->setCacheKeyField('componentAppId');
        $this->setPrefix(static::COMPONENT_VERIFY_TICKET_CACHE_PREFIX);
    }
    /**
     *
     * get verify ticket
     *
     * @return string
     */
    public function getVerifyTicket()
    {
        $cacheKey           = $this->getCacheKey();
        $this->verifyTicket = $this->getCache()->fetch($cacheKey);
        Log::debug('Get verify ticket', [$this->verifyTicket]);
        return $this->verifyTicket;
    }
    /**
     * set verify ticket
     * @param [type] $verifyTicket [description]
     */
    public function setVerifyTicket($verifyTicket)
    {
        $cacheKey           = $this->getCacheKey();
        $this->verifyTicket = $verifyTicket;
        $this->getCache()->save($cacheKey,$verifyTicket);
        Log::debug('Set verify ticket',[$verifyTicket]);
    }
}