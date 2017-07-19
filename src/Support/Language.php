<?php
/**
 * @Author: binghe
 * @Date:   2017-06-22 11:55:08
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-22 18:01:22
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
            ,'40007'=>'不合法的媒体文件id'
            ,'40015'=>'不合法的菜单类型'
            ,'40016'=>'不合法的按钮个数'
            ,'40017'=>'不合法的按钮个数'
            ,'40018'=>'不合法的按钮名字长度'
            ,'40019'=>'不合法的按钮KEY长度'
            ,'40020'=>'不合法的按钮URL长度'
            ,'40022'=>'不合法的子菜单级数'
            ,'40023'=>'不合法的子菜单按钮个数'
            ,'45058'=>'不能修改0/1/2这三个系统默认保留的标签'
            ,'45157'=>'标签名非法，请注意不能和其他标签重名'
            ,'45158'=>'标签名长度超过30个字节'
            ,'48001'=>'api功能未授权，请确认公众号已获得该接口'
            ,'50001'=>'用户未授权该api'

        ]
    ];
    /**
     * 获取message
     * @var string
     */
    public static function getMessage($errCode,$errMsg='',$language='zh_cn') 
    {
        $languageMapping=self::$msgMapping[$language];
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