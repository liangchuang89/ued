<?php
/**
 * 创建于13-1-17，下午8:46
 * @author 宇山<yushan.yk@taobao.com>
 */
class MainCommandTest extends PHPUnit_Framework_TestCase
{
    protected $main;
    /**
     * 类初始化条件
     */
    protected function setUp()
    {
        $this->main = new MainCommand(array());
    }

    public function testProcess(){

    }
}