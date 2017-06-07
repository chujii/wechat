<?php
/**
 * @Author: binghe
 * @Date:   2017-06-01 13:38:26
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-07 17:22:42
 */
/**
* 测试
*/
require_once __DIR__ . './../vendor/autoload.php';
use Binghe\Wechat\Core\ComponentVerifyTicket;
use Binghe\Wechat\Foundation\Application;
// define('BINGHE_MONOLOG_PATH',__DIR__ . './../tmp/'.date('Y-m-d').'.log');
// $componentVerifyTicket = new ComponentVerifyTicket('tiket_app_id');
// $componentVerifyTicket->setVerifyTicket('verify_tiket_value000000000001');
// echo "set-ok\n";
// $ticket=$componentVerifyTicket->getVerifyTicket();
// echo $ticket.'-';
$config=[
'debug'=>true,
'component_app_id'=>'ticket_app_id',
'log' => [                                              //日志
        'level' => 'debug',
        'file'  => __DIR__ . './../tmp/'.date('Y-m-d').'.log',
    ]
];
$app = new Application($config);
// var_dump($app->component_verify_ticket);
// $app->component_verify_ticket->setVerifyTicket('verify_tiket_value0000000');

// $app->component_verify_ticket->getVerifyTicket();
$responser=$app->app_server->handle();
$responser->send();

