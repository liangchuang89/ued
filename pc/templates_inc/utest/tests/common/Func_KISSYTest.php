<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yukan
 * Date: 13-8-22
 * Time: 下午3:43
 * To change this template use File | Settings | File Templates.
 */

class Func_KISSYTest extends PHPUnit_Framework_TestCase {
    /**
     * @var Func_KISSY
     */
    protected $cf;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        C::dispose();
        $this->cf = new Func_KISSY();
    }

    protected function tearDown(){
        C::dispose();
    }
    /**
     * @covers Func_KISSY::combineAllFile
     */
    public function test_combineAllFile(){
        $filepack = $this->getMock('InterfaceMock',array('scriptTag'));

        $filepack->expects($this->once())
            ->method('scriptTag')
            ->with($this->equalTo("(function(){ var a ='a'; }());(function(){ var a ='index'; }());"))
            ->will($this->returnValue('<script></script>'));


        C::registerFacade('html','',$filepack);

        $html = $this->cf->combineAllFile(ROOT.'/src/init');
        $this->assertEquals("<script></script>", $html);
    }

    /**
     * @covers Func_KISSY::buildInitFiles
     */
    public function test_buildInitFiles_when_mode_equal_dev_without_src_init()
    {
        P::dispose();
        P::initGETParam(array('mode'=>'dev'));
        //mode=dev,src下无init目录
        $filepack = $this->getMock('InterfaceMock',array('trans2dev','jsScriptTag','scriptTag','commentTag'));

        //mock 生成注释的标签的方法
        $filepack->expects($this->once())
            ->method('commentTag')
            ->with($this->equalTo('以下生成的imports-style.js的标签，package配置，引入的src下的init都为dev情况，请不要让开发童鞋加入这段HTML的源码'))
            ->will($this->returnValue('<!-- -->'));
        //mock import-style.js的标签的方法
        $filepack->expects($this->once())
            ->method('jsScriptTag')
            ->with($this->equalTo('http://assets.etao.net/apps/e/kissy/import-style.js'))
            ->will($this->returnValue('<script src=""></script>'));
        //mock 生成package的方法
        $filepack->expects($this->once())
            ->method('scriptTag')
            ->with($this->equalTo("KISSY.config({combine:false,packages:[{name:'components',debug:true,path: '.'}]});"))
            ->will($this->returnValue('<script></script>'));
        //mock 获取src/init的方法
        $filepack->expects($this->once())
            ->method('trans2dev')
            ->with($this->equalTo('src/init'))
            ->will($this->returnValue(array()));


        C::registerFacade('html','',$filepack);
        C::registerFacade('filepack','',$filepack);
        $this->assertEquals(
            '<!-- --><script src=""></script><script></script>',
            $this->cf->buildInitFiles('131313')
        );
        C::dispose();
    }
    /**
     * @covers Func_KISSY::buildInitFiles
     */
    public function test_buildInitFiles_when_mode_equal_dev_with_src_init()
    {
        P::dispose();
        P::initGETParam(array('mode'=>'dev'));
        //mode=dev,src下无init目录
        $filepack = $this->getMock('InterfaceMock',array('trans2dev','jsScriptTag','scriptTag','commentTag'));

        //mock 生成注释的标签的方法
        $filepack->expects($this->once())
            ->method('commentTag')
            ->with($this->equalTo('以下生成的imports-style.js的标签，package配置，引入的src下的init都为dev情况，请不要让开发童鞋加入这段HTML的源码'))
            ->will($this->returnValue('<!-- -->'));
        //mock import-style.js的标签的方法
        $filepack->expects($this->any())
            ->method('jsScriptTag')
            ->will($this->returnValue('<script src=""></script>'));
        //mock 生成package的方法
        $filepack->expects($this->once())
            ->method('scriptTag')
            ->with($this->equalTo("KISSY.config({combine:false,packages:[{name:'components',debug:true,path: '.'}]});"))
            ->will($this->returnValue('<script></script>'));
        //mock 获取src/init的方法
        $filepack->expects($this->once())
            ->method('trans2dev')
            ->with($this->equalTo('src/init'))
            ->will($this->returnValue(array('a.js')));

        C::registerFacade('html','',$filepack);
        C::registerFacade('filepack','',$filepack);
        $this->assertEquals(
            '<!-- --><script src=""></script><script></script><script src=""></script>',
            $this->cf->buildInitFiles('131313')
        );
        C::dispose();
    }
    /**
     * @covers Func_KISSY::buildInitFiles
     */
    public function test_bootpage_when_mode_not_equal_dev()
    {
        C::dispose();
        P::dispose();
        P::initGETParam(array('mode'=>'asset'));

        $filepack = $this->getMock('InterfaceMock',array('trans2assets','jsScriptTag'));
        $filepack->expects($this->any())
            ->method('trans2assets')
            ->with($this->equalTo('src/init'),$this->equalTo('131313'),$this->equalTo('js'))
            ->will($this->returnValue('http://src/init.js'));
        $filepack->expects($this->any())
            ->method('jsScriptTag')
            ->with($this->equalTo('http://src/init.js'))
            ->will($this->returnValue('<script></script>'));

        C::registerFacade('html','',$filepack);
        C::registerFacade('filepack','',$filepack);
        $this->assertEquals(
            '<script></script>',
            $this->cf->buildInitFiles('131313')
        );
        C::dispose();
    }



    /**
     * @cover Func_KISSY::importStyle
     */
    public function test_importStyle_when_mode_equals_dev(){
        $filepack = $this->getMock('InterfaceMock',
            array('trans2dev','cssStyleTag'));
        $filepack->expects($this->once())
            ->method('trans2dev')
            ->with($this->equalTo('components/a,components/b'))
            ->will($this->returnValue(array('cssfiles')));
        $filepack->expects($this->once())
            ->method('cssStyleTag')
            ->with($this->equalTo(array('cssfiles')))
            ->will($this->returnValue('cssStyleTag'));

        C::registerFacade('html','',$filepack);
        C::registerFacade('filepack','',$filepack);
        P::initGETParam(array('mode'=>"dev"));
        $this->assertEquals('cssStyleTag',$this->cf->importStyle(' a, b','131313'));
    }

    /**
     * @cover Func_KISSY::importStyle
     */
    public function test_importStyle_when_mode_not_equal_dev(){
        C::dispose();
        P::dispose();
        P::initGETParam(array('mode'=>'asset'));
        $filepack = $this->getMock('InterfaceMock',
            array('trans2assets','cssLinkTag'));
        $filepack->expects($this->once())
            ->method('trans2assets')
            ->with($this->equalTo('components/a,components/b'),$this->equalTo('131313'))
            ->will($this->returnValue('csslink'));
        $filepack->expects($this->once())
            ->method('cssLinkTag')
            ->with($this->equalTo('csslink'))
            ->will($this->returnValue('csslinkTag'));

        C::registerFacade('html','',$filepack);
        C::registerFacade('filepack','',$filepack);
        $this->assertEquals('csslinkTag',$this->cf->importStyle(' a, b','131313'));
    }
}
