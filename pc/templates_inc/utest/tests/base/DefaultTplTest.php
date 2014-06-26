<?php
/**
 * 创建于13-1-18，上午11:50
 * @author 宇山<yushan.yk@taobao.com>
 */
class DefaultTplTest extends PHPUnit_Framework_TestCase
{
    protected $dt;
    /**
     * 类初始化条件
     */
    protected function setUp()
    {
        $this->dt = new DefaultTpl();
    }

    /**
     * @dataProvider key_path
     * @covers DefaultTpl::getTpl
     */
    public function testGetTpl($key, $path)
    {
        $this->assertEquals("Just Test {{test}}{{#arr}}{{name}}{{/arr}}",$this->dt->getTpl($key,$path));
    }
    public function key_path(){
        return array(
            array("acomponent",ROOT."/components/acomponent/template.html"),
            array("component",ROOT."/components/component/template.html"),
            array("_component_",ROOT."/components/_component_/template.html"),
            array("srepo.ux.etao/component",ROOT."/imports/srepo.ux.etao/component/template.html"),
        );
    }
}