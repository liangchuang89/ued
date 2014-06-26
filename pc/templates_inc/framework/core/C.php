<?php
/**
 * Context的简称，程序环境
 * @author 宇山<yushan.yk@taobao.com>
 * @package core
 */
class C
{
    /**
     * 静态资源释放
     */
    public static function dispose()
    {
        self::$facade = array();
    }

/// 命令模型 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * 执行某一个命令
     * @param ICommand $command
     * TODO 实现简单的命令模型实现，如果命令膨胀，则使用动态外观扩展
     */
    public static function excute(ICommand $command){
        $command->excute();
    }

    /**
     * 初始化
     * @param $config
     */
    public static function init($config)
    {
        if(array_key_exists("facade",$config)){
            foreach ($config["facade"] as $key => $facade) {
                self::registerFacade($key,$facade['description'],$facade['module']);
            }
        }
        if(array_key_exists("main",$config)) self::excute($config['main']);

    }

/*// 外观实现方式 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    private static $facade = array();//外观数组
    /**
     * 注册外观
     * @param $key 关键字
     * @param $description 描述
     * @param $module 模块实例
     */
    public static function registerFacade($key, $description, $module){
        if(array_key_exists($key,self::$facade)){
            L::e($key."对应外观已存在");
        }else{
            self::$facade[$key] = array(
                'key'           => $key,
                'description'   => $description,
                'module'           => $module
            );
        }
    }
    /**
     * 删除外观
     * @param $key 关键字
     */
    public static function removeFacade($key){
        if(array_key_exists($key,self::$facade)){
            unset(self::$facade[$key]);
        }
    }

    /**
     * 获取对应的外观
     * f是facade的缩写
     * @param $key 关键字
     * @return mixed 返回对应模块实例
     */
    public static function f($key){
        return self::$facade[$key]['module'];
    }

    /**
     * 获取模块的模式
     * @param $key
     * @return mixed 返回描述的字符串
     */
    public static function describe($key){
        return self::$facade[$key]['description'];
    }
}
