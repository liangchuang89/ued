<?php
/**
 * 创建于13-1-11，下午5:54
 * @author 宇山<yushan.yk@taobao.com>
 */
class LTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown(){
        L::dispose();
    }

    /**
     * @covers L::d
     * @covers L::e
     * @covers L::r
     * @covers L::o
     */
    public function testLog(){
        L::d('debug');
        L::e('error');
        L::r('record');

        $result = L::o();
        $debugRight = false;
        foreach ($result['debug'] as $debug) {
            if(preg_match('/debug/',$debug)){
                $debugRight = true;
                break;
            }
        }
        $this->assertTrue($debugRight);

        $errorRight = false;
        foreach ($result['error'] as $error) {
            if(preg_match('/error/',$error)){
                $errorRight = true;
                break;
            }
        }
        $this->assertTrue($errorRight);

        $recordRight = false;
        foreach ($result['record']['default'] as $record) {
            if(preg_match('/record/',$record)){
                $recordRight = true;
                break;
            }
        }
        $this->assertTrue($recordRight);

    }
}