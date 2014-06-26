<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yukan
 * Date: 13-8-22
 * Time: 下午3:17
 * To change this template use File | Settings | File Templates.
 */

class Func_addTest extends PHPUnit_Framework_TestCase {
    /**
     * @var Func_add
     */
    protected $cf;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->cf = new Func_add();
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
     * @covers Func_add::add
     */
    public function testAdd()
    {
        P::dispose();
        P::set("page","index");

        $this->assertEquals(
            array(ROOT."/templates/index/a.php",CommonUtils::MODE_INCLUDE),
            $this->cf->add("a.php")
        );
        $this->assertEquals(
            array(ROOT."/templates/index/a.php",CommonUtils::MODE_INCLUDE),
            $this->cf->add("a")
        );
        P::dispose();
    }
}
