<?php
/**
 * @Author: binghe
 * @Date:   2017-06-08 10:33:49
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-08 10:34:52
 */
namespace Binghe\Wechat\Traits;


use Binghe\Wechat\Support\Http;

trait HttpTrait
{
    /**
     * Http instance.
     *
     * @var Http
     */
    protected $http;

    /**
     * Return the http instance.
     *
     * @return \Binghe\Wechat\Core\Http
     */
    public function getHttp()
    {
        return $this->http ?: $this->http = new Http();
    }

    /**
     * Set the http instance.
     *
     * @param \Binghe\Wechat\Core\Http $http
     *
     * @return $this
     */
    public function setHttp(Http $http)
    {
        $this->http = $http;

        return $this;
    }

}