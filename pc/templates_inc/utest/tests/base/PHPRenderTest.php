<?php
/**
 * 创建于13-1-18，上午11:51
 * @author 宇山<yushan.yk@taobao.com>
 */
class PHPRenderTest extends PHPUnit_Framework_TestCase
{
    protected $render;
    /**
     * 类初始化条件
     */
    protected function setUp()
    {
        include_once INC."/thirdparty/Mustache/Autoloader.php";
        Mustache_Autoloader::register();
        $me = new Mustache_Engine();
        $this->render = new PHPRender($me);
    }
    /**
     * @covers PHPRender::render
     */
    public function testRender()
    {
        $html = $this->render->render("{{ss}}",array("ss" => "sas"),"ss");
        $this->assertEquals("sas",$html);
    }
}