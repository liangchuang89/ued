<?php
/**
 * 创建于13-1-14，上午11:23
 * @author 宇山<yushan.yk@taobao.com>
 */
class EventDispatcherTest extends PHPUnit_Framework_TestCase
{
    protected $dispatcher;
    private $event;
    private $fl1;
    private $fl2;
    /**
     * 类初始化条件
     */
    protected function setUp()
    {
        $this->dispatcher = new EventDispatcher();
        $this->event = $this->getMock("IEvent",array("type","setContent","getContent"));
        $this->event->expects($this->any())
            ->method('type')
            ->will($this->returnValue('eventType'));

        $this->fl2 = new FakeListener('listener');

    }

    /**
     *
     * @covers EventDispatcher::addListener
     * @covers EventDispatcher::removeListener
     * @covers EventDispatcher::hasListener
     */
    public function testRemoveListener()
    {
        $this->dispatcher->addListener('eventType',array($this->fl2,'response'));
        $this->assertTrue($this->dispatcher->hasListener('eventType',array($this->fl2,'response')));
        $this->dispatcher->removeListener('eventType',array($this->fl2,'response'));
        $this->assertFalse($this->dispatcher->hasListener('eventType',array($this->fl2,'response')));
    }

    /**
     * @covers EventDispatcher::dispatch
     */
    public function testDispatch()
    {
        $this->dispatcher->addListener('eventType',array($this->fl2,'response'));
        $this->dispatcher->dispatch($this->event);
        $this->assertEquals('listener',$this->fl2->response);
        $this->assertEquals($this->event,$this->fl2->event);
    }

}

class FakeListener{

    private $key;
    public $response;
    public $event;
    function __construct($key)
    {
        $this->key = $key;
    }

    public function response($event){
        $this->response = $this->key;
        $this->event = $event;
    }
}

