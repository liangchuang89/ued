<?php
$currentPath = dirname(__FILE__);
define('INC',realpath($currentPath.'/../../../../'));
include_once INC . "/framework/autoload.php";
$ti_autoloader = new TI_Autoloader();
$ti_autoloader->add(array(
    "default"=>array("core","event","common","commands"),
    "auto"=>array("base")
));
/**
 * 测试自动加载机制
 * 创建于13-1-8，下午7:52
 * @author 宇山<yushan.yk@taobao.com>
 */
class AutoLoadTest extends PHPUnit_Framework_TestCase
{
    /**
     * 测试加载默认类文件
     */
    public function testLoadDefaultClass(){
        $this->assertTrue(class_exists('C'));
        $this->assertTrue(interface_exists('ICommand'));
        $this->assertTrue(interface_exists('IData'));
        $this->assertTrue(interface_exists('IEventDispatcher'));
        $this->assertTrue(interface_exists('IPlugin'));
        $this->assertTrue(interface_exists('IRender'));
        $this->assertTrue(class_exists('L'));
        $this->assertTrue(class_exists('P'));
        $this->assertTrue(class_exists('MainCommand'));
        $this->assertTrue(function_exists('add'));
        $this->assertTrue(function_exists('components'));
        $this->assertTrue(function_exists('css'));
        $this->assertTrue(function_exists('eassets'));
        $this->assertTrue(function_exists('efooter'));
        $this->assertTrue(function_exists('eheader'));
        $this->assertTrue(function_exists('imports'));
        $this->assertTrue(function_exists('js'));
        $this->assertTrue(class_exists('TIEvent'));
        $this->assertTrue(class_exists('EventDispatcher'));
    }
    /**
     * 测试自动加载类文件
     */
    public function testAutoloadClass()
    {
        $this->assertTrue(class_exists('DefaultData'));
        $this->assertTrue(class_exists('FilePack'));
    }
}