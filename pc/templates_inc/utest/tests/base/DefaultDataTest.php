<?php
/**
 * 创建于13-1-18，上午11:49
 * @author 宇山<yushan.yk@taobao.com>
 */
class DefaultDataTest extends PHPUnit_Framework_TestCase
{
    protected $dd;
    /**
     * 类初始化条件
     */
    protected function setUp()
    {
        $this->dd = new DefaultData();
    }

    /**
     * @dataProvider key_path
     * @covers DefaultData::getData
     */
    public function testGetData($key, $path)
    {
        $this->assertJsonStringEqualsJsonString('{"test":"this is test.","arr":[{"name":"1"},{"name":"2"},{"name":"3"}]}',$this->dd->getData($key,$path));
    }
    public function key_path(){
        return array(
            array("acomponent",ROOT."/components/acomponent/data.json"),
            array("component",ROOT."/components/component/data.json"),
            array("_component_",ROOT."/components/_component_/data.json"),
            array("srepo.ux.etao/component",ROOT."/imports/srepo.ux.etao/component/data.json"),
        );
    }
}