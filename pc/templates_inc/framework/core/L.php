<?php
/**
 * 框架行为记录，不要掺杂任何其他的类的代码，保证记录类的纯净。
 * @package core
 */
class L
{
    /**
     * 日志数组
     * @var array
     */
    private static $logArr = array('debug'=>array(),'error'=>array(),'record'=>array());
    /**
     * 输出Debug信息
     * @static
     * @param $msg
     */
    public static function d($msg){
        array_push(self::$logArr['debug'],$msg);
    }

    /**
     * error输出错误信息
     * @static
     * @param $msg
     */
    public static function e($msg){
        array_push(self::$logArr['error'],$msg);
        echo $msg;
    }

    /**
     * record记录
     * @static
     * @param $msg
     * @param $key
     */
    public static function r($msg,$key = 'default'){
        if(!array_key_exists($key,self::$logArr['record'])) self::$logArr['record'][$key] = array();
        array_push(self::$logArr['record'][$key],$msg);
    }

    /**
     * 返回日志的数组
     * @static
     */
    public static function o(){
        return self::$logArr;
    }

    /**
     * 静态资源释放
     */
    public static function dispose()
    {
        self::$logArr = array('debug'=>array(),'error'=>array(),'record'=>array());
    }
}
