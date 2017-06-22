<?php
/**
 * @Author: binghe
 * @Date:   2017-06-19 17:53:10
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-21 16:14:59
 */
namespace Binghe\Wechat\Tests;
use PHPUnit\Framework\TestCase as BaseTestCase;
/**
* Test base
*/
class TestCase extends BaseTestCase
{
    /**
     * Tear down the test case.
     */
    public function tearDown()
    {
        $this->finish();
        parent::tearDown();
        if ($container = \Mockery::getContainer()) {
            $this->addToAssertionCount($container->Mockery_getExpectationCount());
        }
        \Mockery::close();
    }
    /**
     * Run extra tear down code.
     */
    protected function finish()
    {
        // call more tear down methods
    }
}