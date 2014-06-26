<?php
/**
 * <h3>新的使用$_GET参数的方式</h3>
 * 原来在页面里面我们的使用GET的方法：
 * <pre>
 * &lt;?php
 * if(isset($_GET['get'] && $_GET['key'] == 'value')
 * ?&gt;
 * </pre>
 * 这种方式有两个缺点：
 * <ul>
 * <li>随着系统的增长，系统中不明所以的$_GET参数会越来越多</li>
 * <li>很烦不好打</li>
 * </ul>
 * <h4>template_inc里提供这样的方式：</h4>
 * <pre>
 * &lt;?php
 * //extend为$_GET中的键值，第二个参数为注释会在log工具中展现，第三个为了兼容编码，默认$gbk为true
 * P::get('extend');//使用这个参数
 * P::set('extend','off');//设置这个参数默认值
 * ?&gt;
 * </pre>
 *
 * 
 * @author 宇山<yushan.yk@taobao.com>
 * @package core
 */
class P
{
    /**
     * @var array get的映射
     */
    private static $getMap = array(
        'get'=>array(),
        'history' => array()
    );

    /**
     * 设置参数的值
     * @static
     * @param $key $_GET的键值
     * @param $value 默认值
     */
    public static function set($key,$value){
        $value = htmlspecialchars($value);

        if(!array_key_exists($key,self::$getMap['history'])){
            self::$getMap['history'][$key] = array();
        }
        array_push(self::$getMap['history'][$key], $value);
        self::$getMap['get'][$key] = $value;
    }

    /**
     * 获取传入的GET的值，如果getArr中不存在，则返回null,如果$isHistory为true，则输出历史记录
     * @static
     * @param $key $_GET中的键值
     * @param bool|int $isHistory 是否获取历史记录，默认为false
     * @return null
     */
    public static function get($key, $isHistory = false){
        $getvalue = null;

        if(array_key_exists($key,self::$getMap['get'])){
            if($isHistory){
                $getvalue = self::$getMap['history'][$key];
            }else{
                $getvalue = self::$getMap['get'][$key];
            }
        }
        return $getvalue;
    }

    /**
     * 初始化$_GET参数，若$get为null，则默认获取$_GET中的值
     * @static
     * @param null $get 传入的$_GET数组，默认为null
     * @return array 最终得到的模拟的$_GET数组
     */
    public static function initGETParam($get = null){
        //如果不传入参数，则默认获取$_GET中的值
        if(!$get || !is_array($get)) $get = $_GET;

        foreach($get as $key => $value){
            self::set($key, $value);
        }

        return self::$getMap['get'];
    }

    /**
     * 静态资源释放
     */
    public static function dispose()
    {
        self::$getMap = array(
            'get'   => array(),
            'history' => array()
        );
    }

}
