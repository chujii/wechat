<?php
/**
 * @Author: binghe
 * @Date:   2017-06-19 17:53:10
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-19 17:55:01
 */
namespace Binghe\wechat\Tests;
use PHPUnit\Framework\TestCase as BaseTestCase;
/**
* Test base
*/
class TestCase extends BaseTestCase
{
    public function testEmpty()
    {
        $stack = array();
        $this->assertEmpty($stack);
        return $stack;
    }
}