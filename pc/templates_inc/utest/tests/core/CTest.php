<?php
/**
 * 测试动态添加外观，默认外观，以及命令模型
 * 创建于13-1-9，上午11:07
 * @author 宇山<yushan.yk@taobao.com>
 */
class CTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown(){
        C::dispose();
    }
    /**
     * 测试初始化方法
     * @covers C::init
     * @covers C::f
     * @covers C::registerFacade
     * @covers C::describe
     */
    public function testInit(){
        $fakeModule = array();
        C::init(array(
            "facade"=> array(
                'fake'=>array(
                    'description' => 'fake descriptioin',
                    'module' => $fakeModule
                )
            ),
            "main" => new FakeInitCommand()
        ));
        $f2= C::f('fake');
        $this->assertEquals($fakeModule,$f2);
        $this->assertEquals('fake descriptioin',C::describe('fake'));
        $this->assertTrue(FakeInitCommand::$excuted);


    }

}

/**
 * 伪对象，隔离原有EventDispatcher的行为
 * @see event/EventDispatcher
 */
class FakeEventDispatcher{

}

/**
 * 初始化命令的伪对象
 */
class FakeInitCommand implements ICommand
{
    static $excuted = false;
    /**
     * @inheritdoc
     */
    function excute()
    {
        self::$excuted = true;
    }
}