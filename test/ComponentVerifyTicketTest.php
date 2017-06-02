<?php
/**
 * @Author: binghe
 * @Date:   2017-06-01 13:38:26
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-02 10:50:36
 */
/**
* 测试
*/
require_once __DIR__ . './../vendor/autoload.php';
use Binghe\Wechat\Core\ComponentVerifyTicket;
define('BINGHE_MONOLOG_PATH',__DIR__ . './../tmp/'.date('Y-m-d').'.log');
$componentVerifyTicket = new ComponentVerifyTicket('tiket_app_id');
$componentVerifyTicket->setVerifyTicket('verify_tiket_value000000000001');
echo "set-ok\n";
$ticket=$componentVerifyTicket->getVerifyTicket();
echo $ticket.'-';

