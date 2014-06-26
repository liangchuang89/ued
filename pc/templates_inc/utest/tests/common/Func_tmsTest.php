<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yukan
 * Date: 13-8-22
 * Time: 下午3:17
 * To change this template use File | Settings | File Templates.
 */

class Func_tmsTest extends PHPUnit_Framework_TestCase {
    /**
     * @var Func_tms
     */
    protected $cf;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->cf = new Func_tms();
        C::dispose();
        $eventdispatcher = $this->getMock('IEventDispatcher',array('addListener','removeListener','hasListener','dispatch'));
        $eventdispatcher->expects($this->atLeastOnce())//这个方法至少被调用一次
            ->method('dispatch')
            ->with($this->anything());
        C::registerFacade('e','',$eventdispatcher);
    }

    protected function tearDown(){
        C::dispose();
    }

    /**
     * @covers Func_tms::tms
     */
    public function testTms_when_mode_equal_dev()
    {
        P::dispose();
        P::set("mode","dev");
        $this->assertEquals(
            array('a',CommonUtils::MODE_ECHO_FILE),
            $this->cf->tms('a','b',false)
        );
        P::dispose();
    }
    /**
     * @covers Func_tms::tms
     */
    public function testTms_when_mode_not_equal_dev()
    {
        P::dispose();
        P::set("mode","assets");
        $this->assertEquals(
            array('b',CommonUtils::MODE_ECHO_GBKFILE),
            $this->cf->tms('a','b')
        );
        P::dispose();
    }
}
