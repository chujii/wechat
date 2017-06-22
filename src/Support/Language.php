<?php
/**
 * @Author: binghe
 * @Date:   2017-06-22 11:55:08
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-22 13:48:39
 */
namespace Binghe\Wechat\Support;
/**
* 错误
*/
class Language
{
    static $msgMapping=[
        'zh_cn'=>[
            '-1'=>'系统繁忙'
            ,'0'=>'请求成功'
            ,'45058'=>'不能修改0/1/2这三个系统默认保留的标签'
            ,'45157'=>'标签名非法，请注意不能和其他标签重名'
            ,'45158'=>'标签名长度超过30个字节'

        ]
    ];
    /**
     * 获取message
     * @var string
     */
    public static function getMessage($errCode,$errMsg='',$language='zh_cn') 
    {
        $languageMapping=self::msgMapping[$language];
        if($languageMapping)
        {
            foreach ($languageMapping as $code => $msg) {
                if($errCode==$code)
                {
                    $errMsg=$msg;
                    break;
                }
            }
        }
        return $errMsg;
    }
}