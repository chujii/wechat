<?php
/**
 * @Author: binghe
 * @Date:   2017-05-31 13:52:59
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-05-31 14:02:47
 */
namespace Binghe\Wechat\Core;
/**
* 
*/
class Application 
{
    public function __construct($config)
    {
        
    }
    public function setMessageHandler(\Closure $closure)
    {
        MessageHandler::getInstance()->setMessageHandler($closure);
    }
}