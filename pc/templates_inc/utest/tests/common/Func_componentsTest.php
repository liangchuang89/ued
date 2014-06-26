<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yukan
 * Date: 13-8-22
 * Time: 下午3:17
 * To change this template use File | Settings | File Templates.
 */

class Func_componentsTest extends PHPUnit_Framework_TestCase {
    /**
     * @var Func_components
     */
    protected $cf;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        //必须发出一个事件
        C::dispose();
        $eventdispatcher = $this->getMock('IEventDispatcher',array('addListener','removeListener','hasListener','dispatch'));
        $eventdispatcher->expects($this->atLeastOnce())//这个方法至少被调用一次
            ->method('dispatch')
            ->with($this->anything());
        C::registerFacade('e','',$eventdispatcher);

        $this->cf = new Func_components();
    }

    protected function tearDown(){
        C::dispose();
        CommonUtils::dispose();
    }

    /**
     * @covers Func_components::components
     */
    public function testDefault_render_action()
    {
        //mock 路径分解
        $utils1 = $this->getMock('FuncUtils',array('breakPath'));
        $utils1->expects($this->atLeastOnce())
            ->method('breakPath')
            ->with(
                $this->equalTo('ssss')
            )->will($this->returnValue(
                array(
                    Func_components::DEFAULT_RENDER,
                    'ssss'
                )
            ));

        CommonUtils::setUp(array(),array(
            'default'=> $utils1
        ));
        /*mock核心模块*/
        //数据模块
        $data = $this->getMock('DefaultData',array('getData'));
        $data->expects($this->atLeastOnce())//这个方法至少被调用一次
            ->method('getData')
            ->with(
                $this->equalTo('ssss'),
                $this->equalTo(ROOT.'/components/ssss/data.json')
            )->will($this->returnValue('{"a":"a"}'));
        C::registerFacade('data','',$data);
        //模板模块
        $tpl = $this->getMock('DefaultTpl',array('getTpl'));
        $tpl->expects($this->atLeastOnce())//这个方法至少被调用一次
            ->method('getTpl')
            ->with(
                $this->equalTo('ssss'),
                $this->equalTo(ROOT.'/components/ssss/template.html')
            )->will($this->returnValue('tpl'));
        C::registerFacade('tpl','',$tpl);
        //渲染模块
        $render = $this->getMock('PHPRender',array('render'));
        $render->expects($this->atLeastOnce())//这个方法至少被调用一次
            ->method('render')
            ->with(
                $this->equalTo('tpl'),
                $this->equalTo(array('a'=>'a')),
                $this->equalTo('ssss')
            )->will($this->returnValue('finalComp'));
        C::registerFacade('render','',$render);

        $this->assertEquals(
            CommonUtils::preReturn(
                'finalComp',
                CommonUtils::MODE_ECHO),
            $this->cf->components('ssss')
        );
    }
    /**
     * 利用key来自定义
     * @covers Func_components::components
     */
    public function testCustomUseKey_render_action()
    {
        //mock 路径分解
        $utils1 = $this->getMock('FuncUtils',array('breakPath'));
        $utils1->expects($this->atLeastOnce())
            ->method('breakPath')
            ->with(
                $this->equalTo('ssss')
            )->will($this->returnValue(
                array(
                    Func_components::DEFAULT_RENDER,
                    'ssss'
                )
            ));


        CommonUtils::setUp(array(),array(
            'default'=> $utils1
        ));
        /*mock核心模块*/
        //数据模块
        $data = $this->getMock('DefaultData',array('getData'));
        $data->expects($this->atLeastOnce())//这个方法至少被调用一次
            ->method('getData')
            ->with(
                $this->equalTo('ssss'),
                $this->equalTo(ROOT.'/components/ssss/data_key.json')
            )->will($this->returnValue('{"a":"a"}'));
        C::registerFacade('data','',$data);
        //模板模块
        $tpl = $this->getMock('DefaultTpl',array('getTpl'));
        $tpl->expects($this->atLeastOnce())//这个方法至少被调用一次
            ->method('getTpl')
            ->with(
                $this->equalTo('ssss'),
                $this->equalTo(ROOT.'/components/ssss/template_key.html')
            )->will($this->returnValue('tpl'));
        C::registerFacade('tpl','',$tpl);
        //渲染模块
        $render = $this->getMock('PHPRender',array('render'));
        $render->expects($this->atLeastOnce())//这个方法至少被调用一次
            ->method('render')
            ->with(
                $this->equalTo('tpl'),
                $this->equalTo(array('a'=>'a')),
                $this->equalTo('ssss')
            )->will($this->returnValue('finalComp'));
        C::registerFacade('render','',$render);

        $this->assertEquals(
            CommonUtils::preReturn(
                'finalComp',
                CommonUtils::MODE_ECHO),
            $this->cf->components('ssss', array(
                'data' => 'key',
                'tpl' => 'key'
            ))
        );
    }
    /**
     * 对象来自定义
     * @covers Func_components::components
     */
    public function testCustomUseObject_render_action()
    {
        //mock 路径分解
        $utils1 = $this->getMock('FuncUtils',array('breakPath'));
        $utils1->expects($this->atLeastOnce())
            ->method('breakPath')
            ->with(
                $this->equalTo('ssss')
            )->will($this->returnValue(
                array(
                    Func_components::DEFAULT_RENDER,
                    'ssss'
                )
            ));


        CommonUtils::setUp(array(),array(
            'default'=> $utils1
        ));


        $data = array();
        $tpl = array('tpl');
        /*mock核心模块*/
        //渲染模块
        $render = $this->getMock('PHPRender',array('render'));
        $render->expects($this->atLeastOnce())//这个方法至少被调用一次
            ->method('render')
            ->with(
                $this->equalTo('tpl'),
                $this->equalTo($data),
                $this->equalTo('ssss')
            )->will($this->returnValue('finalComp'));
        C::registerFacade('render','',$render);

        $this->assertEquals(
            CommonUtils::preReturn(
                'finalComp',
                CommonUtils::MODE_ECHO),
            $this->cf->components('ssss', array(
                'data' => $data,
                'tpl' => $tpl
            ))
        );
    }

}
