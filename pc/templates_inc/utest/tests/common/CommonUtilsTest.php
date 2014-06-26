<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yukan
 * Date: 13-8-21
 * Time: 下午9:18
 * To change this template use File | Settings | File Templates.
 */

class CommonUtilsTest extends PHPUnit_Framework_TestCase {

    /**
     * @cover CommonUtils::setUp
     * @cover CommonUtils::func
     * @cover CommonUtils::dispose
     */
    public function testFunc()
    {
        $a = 'asdf';
        CommonUtils::setUp(array(
            'func' => $a
        ),array());
        $this->assertEquals($a,CommonUtils::func('func'));
        CommonUtils::dispose();
    }
    /**
     * @cover CommonUtils::setUp
     * @cover CommonUtils::utils
     * @cover CommonUtils::dispose
     */
    public function testUtils()
    {
        $a = 'asdf';
        CommonUtils::setUp(array(),array(
            'func' => $a
        ));
        $this->assertEquals($a,CommonUtils::utils('func'));
        CommonUtils::dispose();
    }

    /**
     * @covers CommonUtils::preReturn
     */
    public function testPreReturn()
    {
        $mode = 0;
        $return = "中文字符";

        $this->assertEquals(array($mode,$return),CommonUtils::preReturn($mode,$return));
    }

    /**
     * @dataProvider processReturn
     * @covers CommonUtils::processReturn
     */
    public function testProcessReturn($expect,$return,$mode)
    {
        $this->assertEquals($expect,CommonUtils::processReturn(array($return,$mode)));
    }

    public function processReturn()
    {
        return array(
            array(CommonUtils::ECHO_SUCCESS,           "ssssss",                              CommonUtils::MODE_ECHO),
            array(CommonUtils::ECHO_GBK_SUCCESS,       "中文gg字符",                           CommonUtils::MODE_ECHO_GBK),
            array(CommonUtils::ECHO_FILE_SUCCESS,      ROOT."/templates/index/index.php",     CommonUtils::MODE_ECHO_FILE),
            array(CommonUtils::ECHO_GBKFILE_SUCCESS,   ROOT."/templates/index/index.php",     CommonUtils::MODE_ECHO_GBKFILE),
            array(CommonUtils::INCLUDE_SUCCESS,        ROOT."/templates/index/index.php",     CommonUtils::MODE_INCLUDE),
            array(iconv("UTF-8","GBK","中文字符"),       "中文字符",                             CommonUtils::MODE_RETURN_GBK),
            array("s",                                  "s",                                   CommonUtils::MODE_DO_NOTHING)
        );
    }
}
