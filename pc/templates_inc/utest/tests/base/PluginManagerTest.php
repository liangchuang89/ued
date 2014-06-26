<?php
/**
 * PluginEvent类接缝
 */
class PluginEvent implements IEvent{
    static $content = array();
    const INIT = 'init';
    function __construct($type,$content = null)
    {
        array_push(self::$content,$content);
    }
    public function type(){}
    public function setContent($content){}
    public function getContent(){}
}
/**
 * 创建于13-2-5，上午11:06
 * @author 宇山<yushan.yk@taobao.com>
 */
class PluginManagerTest extends PHPUnit_Framework_TestCase
{
    protected $pm;
    /**
     * 类初始化条件
     */
    protected function setUp()
    {
        $this->pm = new PluginManager();
    }

    /**
     * 测试组件管理方法
     * @covers PluginManager::addPlugin
     * @covers PluginManager::removePlugin
     * @covers PluginManager::hasPlugin
     */
    public function testManagePlugin(){
        $p1 = $this->getMock("IPlugin",array("name","init","isInit","destroy"));
        $p1->expects($this->any())
            ->method("name")
            ->will($this->returnValue("p1"));
        $p1->expects($this->any())
            ->method("isInit")
            ->will($this->returnValue(false));

        $this->pm->addPlugin($p1);
        $this->assertTrue($this->pm->hasPlugin("p1"));
        $this->pm->removePlugin("p1");
        $this->assertFalse($this->pm->hasPlugin("p1"));
    }

    /**
     * 测试初始化组件数组
     * @covers PluginManager::initPlugins
     */
    public function testInitPlugins(){
        C::dispose();
        $eventdispatcher = $this->getMock('IEventDispatcher',array('addListener','removeListener','hasListener','dispatch'));
        $eventdispatcher->expects($this->atLeastOnce())//这个方法至少被调用一次
            ->method('dispatch')
            ->with($this->anything());
        C::registerFacade('e','',$eventdispatcher);

        $p1 = $this->getMock("IPlugin",array("name","init","isInit","destroy"));
        $p1->expects($this->any())
            ->method("name")
            ->will($this->returnValue("p1"));
        $p1->expects($this->once())
            ->method("init");
        $p2 = $this->getMock("IPlugin",array("name","init","isInit","destroy"));
        $p2->expects($this->any())
            ->method("name")
            ->will($this->returnValue("p2"));
        $p2->expects($this->once())
            ->method("init");

        $this->pm->addPlugin($p1);
        $this->pm->addPlugin($p2);

        $this->pm->initPlugins();

        $this->assertEquals(
            array(
                array('pluginName' => 'p1'),
                array('pluginName' => 'p2')
            ),
            PluginEvent::$content);
    }
}