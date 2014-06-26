<?php
class CC{

}

/**
 * 创建于13-1-25，上午10:55
 * @author 宇山<yushan.yk@taobao.com>
 */
class PHPTest extends PHPUnit_Framework_TestCase
{
    /**
     * 类初始化条件
     */
    protected function setUp()
    {

    }

    public function testObj(){
        $a = "ddddd";
        $b = 12341;

        $c1 = array($a,$b);
        $c2 = array($a,12341);

        $this->assertEquals($c2,$c1);
        var_dump($c1 === $c2);
    }
}