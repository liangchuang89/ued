<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class CommonUtils {

    private static $funcs = array();
    private static $utils = array();

    /**
     * 初始化
     * @param null $funcs
     * @param null $utils
     */
    public static function setUp($funcs = null, $utils = null){
        self::$utils = $utils ? $utils : array(
            'default' => new FuncUtils()
        );
        self::$funcs = $funcs ? $funcs : array(
            'base64img' => new Func_base64img(),
            'components'=> new Func_components(),
            'add'       => new Func_add(),
            'tms'       => new Func_tms(),
            'etao'      => new Func_Etao(),
            'js_css'    => new Func_JS_CSS(),
            'kissy'     => new Func_KISSY()
        );
    }

    /**
     * 释放静态资源
     */
    public static function dispose(){
        self::$utils = null;
        self::$funcs = null;
    }

    /**
     * 获取对应的函数模块实例
     * @param $key
     * @return mixed
     */
    public static function func($key){
        return self::$funcs[$key];
    }

    /**
     * 获取辅助模块
     * @param $key
     * @return mixed
     */
    public static function utils($key = 'default'){
        return self::$utils[$key];
    }

    /**
     * 预处理返回值
     * @param $return
     * @param int $mode
     * @return array
     */
    public static function preReturn($return, $mode = self::MODE_ECHO)
    {
        return array($return,$mode);
    }

    /**
     * 输出GBK字符串模式
     */
    const MODE_ECHO_GBK = 0;
    const ECHO_GBK_FAIL = "echo_gbk_fail";
    const ECHO_GBK_SUCCESS = "echo_gbk_success";
    /**
     * 输出模式
     */
    const MODE_ECHO = 1;
    const ECHO_FAIL = "echo_fail";
    const ECHO_SUCCESS = "echo_success";
    /**
     * 输出文件内容
     */
    const MODE_ECHO_FILE = 2;
    const ECHO_FILE_FAIL = "echo_file_fail";
    const ECHO_FILE_SUCCESS = "echo_file_success";
    /**
     * 输出GBK文件内容
     */
    const MODE_ECHO_GBKFILE = 3;
    const ECHO_GBKFILE_FAIL = "echo_gbkfile_fail";
    const ECHO_GBKFILE_SUCCESS = "echo_gbkfile_success";
    /**
     * include
     */
    const MODE_INCLUDE = 4;
    const INCLUDE_FAIL = "include_fail";
    const INCLUDE_SUCCESS = "include_success";
    /**
     * 返回gbk字符串
     */
    const MODE_RETURN_GBK = 5;
    const RETURN_GBK_FAIL = "echo_gbk_fail";

    /**
     * do nothing
     */
    const MODE_DO_NOTHING = 6;
    const DO_NOTHING = "do_nothing";

    /**
     * 对返回值的一些处理
     * @TODO 各种处理的容错
     * @param $config
     * @return int|mixed|string
     */
    public static function processReturn($config)
    {
        $return = $config[0];
        $mode = $config[1];
        switch($mode){
            //将utf8字符串转化成gbk字符串输出
            case self::MODE_ECHO_GBK:
                echo iconv("UTF-8","GBK",$return);
                return self::ECHO_GBK_SUCCESS;

            case self::MODE_ECHO:
                echo $return;
                return self::ECHO_SUCCESS;

            case self::MODE_ECHO_FILE:
                $content = file_get_contents($return);
                if($content){
                    echo $content;
                    return self::ECHO_FILE_SUCCESS;
                }
                return self::ECHO_FILE_FAIL;

            case self::MODE_ECHO_GBKFILE:
                $content = file_get_contents($return);
                if($content){
                    $content = iconv('gbk','utf-8',$content);
                    echo $content;
                    return self::ECHO_GBKFILE_SUCCESS;
                }
                return self::ECHO_GBKFILE_FAIL;

            case self::MODE_INCLUDE:
                $include_success = include($return);
                if($include_success)
                    return self::INCLUDE_SUCCESS;
                else
                    return self::INCLUDE_FAIL;

            case self::MODE_RETURN_GBK:
                return iconv("UTF-8","GBK",$return);
            default:
                return $return;
        }
    }
}
