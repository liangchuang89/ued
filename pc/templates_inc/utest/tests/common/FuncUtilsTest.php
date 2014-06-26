<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yukan
 * Date: 13-9-3
 * Time: 下午8:59
 * To change this template use File | Settings | File Templates.
 */

class FuncUtilsTest extends PHPUnit_Framework_TestCase {
    /**
     * @var FuncUtils
     */
    protected $utils;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->utils = new FuncUtils();
    }

    protected function tearDown(){

    }

    /**
     * @covers FuncUtils::breakPath
     */
    public function testBreakPath()
    {
        $this->assertEquals(
            array(Func_components::DEFAULT_RENDER,'com'),
            $this->utils->breakPath('com')
        );
        $this->assertEquals(
            array(Func_components::RETURN_DATA,'com2'),
            $this->utils->breakPath('com2/json')
        );
        $this->assertEquals(
            array(Func_components::RETURN_TPL,'com3'),
            $this->utils->breakPath('com3/html')
        );
    }
}
