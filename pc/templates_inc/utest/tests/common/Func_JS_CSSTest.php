<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yukan
 * Date: 13-8-22
 * Time: 下午3:36
 * To change this template use File | Settings | File Templates.
 */

class Func_JS_CSSTest extends PHPUnit_Framework_TestCase {
    /**
     * @var Func_JS_CSS
     */
    protected $cf;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->cf = new Func_JS_CSS();
        C::dispose();
        $eventdispatcher = $this->getMock('IEventDispatcher',array('addListener','removeListener','hasListener','dispatch'));
        $eventdispatcher->expects($this->atLeastOnce())//这个方法至少被调用一次
            ->method('dispatch')
            ->with($this->anything());
        C::registerFacade('e','',$eventdispatcher);
        CommonUtils::setUp();
    }

    protected function tearDown(){
        C::dispose();
    }

    /**
     * @covers Func_JS_CSS::css
     */
    public function testCss()
    {
        $dependMock = $this->getMock("DenpendCss",array("cssStyleTag","cssLinkTag","trans2dev","trans2assets"));
        $dependMock->expects($this->any())
            ->method("cssStyleTag")
            ->with($this->contains("dev"))
            ->will($this->returnValue("cssStyleTag"));
        $dependMock->expects($this->any())
            ->method("cssLinkTag")
            ->with($this->anything())
            ->will($this->returnValue("cssLinkTag"));

        $dependMock->expects($this->any())
            ->method("trans2dev")
            ->with($this->equalTo("src/search"),$this->equalTo("css"))
            ->will($this->returnValue(array("dev")));
        $dependMock->expects($this->any())
            ->method("trans2assets")
            ->with(
                $this->equalTo("src/search"),
                $this->equalTo("121212"),
                $this->equalTo("css"),
                $this->equalTo(ASSETS)
            )
            ->will($this->returnValue("assets"));
        C::registerFacade('html','',$dependMock);
        C::registerFacade('filepack','',$dependMock);

        P::dispose();
        P::set("mode","dev");
        $this->assertEquals(
            array("cssStyleTag",CommonUtils::MODE_ECHO),
            $this->cf->css("src/search","121212")
        );
        P::dispose();
        P::set("mode","assets");
        $this->assertEquals(
            array("cssLinkTag",CommonUtils::MODE_ECHO),
            $this->cf->css("src/search","121212")
        );
        P::dispose();

        $this->assertEquals(
            array("cssLinkTag",CommonUtils::MODE_ECHO),
            $this->cf->css("src/search")
        );
    }

    /**
     * @covers Func_JS_CSS::js
     */
    public function testJs()
    {
        $dependMock = $this->getMock("DenpendJs",array("jsScriptTag","trans2dev","trans2assets"));
        $dependMock->expects($this->any())
            ->method("jsScriptTag")
            ->with($this->anything())
            ->will($this->returnValue("jsScriptTag"));

        $dependMock->expects($this->any())
            ->method("trans2dev")
            ->with($this->equalTo("src/search"),$this->equalTo("js"))
            ->will($this->returnValue(array("dev")));
        $dependMock->expects($this->any())
            ->method("trans2assets")
            ->with(
                $this->equalTo("src/search"),
                $this->equalTo("121212"),
                $this->equalTo("js"),
                $this->equalTo(ASSETS)
            )
            ->will($this->returnValue("assets"));
        C::registerFacade('html','',$dependMock);
        C::registerFacade('filepack','',$dependMock);

        P::dispose();
        P::set("mode","dev");
        $this->assertEquals(
            array("jsScriptTag",CommonUtils::MODE_ECHO),
            $this->cf->js("src/search","121212")
        );
        P::dispose();
        P::set("mode","assets");
        $this->assertEquals(
            array("jsScriptTag",CommonUtils::MODE_ECHO),
            $this->cf->js("src/search","121212")
        );
        P::dispose();

        $this->assertEquals(
            array("jsScriptTag",CommonUtils::MODE_ECHO),
            $this->cf->js("src/search")
        );
    }

}
