<?php
/**
 * 创建于13-1-18，上午11:50
 * @author 宇山<yushan.yk@taobao.com>
 */
class JSRenderTest extends PHPUnit_Framework_TestCase
{
    protected $render;
    /**
     * 类初始化条件
     */
    protected function setUp()
    {
        $this->render = new JSRender();
    }

    /**
     * @covers JSRender::render
     */
    public function testRender()
    {
        $html = $this->render->render("{{ss}}\n",array("ss" => "sas"),"srepo.ux.etao/ss");
        $this->assertEquals("<script id=\"J_tpl-srepo-ux-etao-ss\">{{ss}}\n</script>",$html);

        $html = $this->render->render("{{ss}}",array("ss" => "sas"),"srepo.ux.etao/ss");
        $this->assertEquals("",$html);

    }
}