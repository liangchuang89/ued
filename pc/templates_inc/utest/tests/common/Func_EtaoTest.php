<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yukan
 * Date: 13-8-22
 * Time: 下午3:19
 * To change this template use File | Settings | File Templates.
 */

class Func_EtaoTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Func_Etao
     */
    protected $cf;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->cf = new Func_Etao();
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
     * @covers Func_Etao::eassets
     */
    public function testEassets()
    {
        $this->assertEquals(
            array(Func_Etao::ECOMMON_TEMPLATES."assets/index.php?kissyversion=1.2.0&brixversion=1.0",CommonUtils::MODE_ECHO_GBKFILE),
            $this->cf->eassets()
        );
    }

    /**
     * @covers Func_Etao::eheader
     */
    public function testEheader()
    {
        $this->assertEquals(
            array(Func_Etao::ECOMMON_TEMPLATES."header/default.php",CommonUtils::MODE_ECHO_GBKFILE),
            $this->cf->eheader()
        );
    }

    /**
     * @covers Func_Etao::efooter
     */
    public function testEfooter()
    {
        $this->assertEquals(
            array(Func_Etao::ECOMMON_TEMPLATES."footer/index.php",CommonUtils::MODE_ECHO_GBKFILE),
            $this->cf->efooter()
        );
    }
}
