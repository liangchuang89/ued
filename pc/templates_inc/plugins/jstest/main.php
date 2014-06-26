<?php
/**
 * <br>创建于13-3-10，下午7:00
 * @author 宇山<yushan.yk@taobao.com>
 */

$basePath = dirname(__FILE__);

class JSTest {
    private static $dataPool = array();

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key){
        if(array_key_exists($key,self::$dataPool))
            return self::$dataPool[$key];
        else
            return null;
    }

    /**
     * @param $key
     * @param $value
     */
    public static function set($key,$value){
        self::$dataPool[$key] = $value;
    }

    /**
     * 自动加载
     * @param $class
     */
    public static function autoload($class){
        if (strpos($class, 'JSTest') !== 0) {
            return;
        }

        $file = sprintf('%s/%s.php', self::get('basePath'), str_replace('_', '/', $class));
        if (is_file($file)) {
            require $file;
        }
    }

    public static function addJSTestHere($config = null){
        if($config){
            foreach ($config as $key => $v) {
                self::set($key,$v);
            }
        }
        C::f('e')->dispatch(new JSTest_Event(JSTest_Event::ADD_TESTS));
    }
}

JSTest::set('basePath',$basePath);
JSTest::set('repoRoot',ROOT);
JSTest::set('testRoot',ROOT.'/test');
spl_autoload_register("JSTest::autoload");

//添加需要加载的异步模块
$testConfig = json_decode(file_get_contents(ROOT.'/test/config.json'),true);
if(array_key_exists('asyncCases',$testConfig) && array_key_exists(P::get('page'),$testConfig['asyncCases'])){
    JSTest::set('uitestASyncCase',$testConfig['asyncCases'][P::get('page')]);
}
if(array_key_exists('autoLoadComponnentCase',$testConfig) && $testConfig['autoLoadComponnentCase'] == 'off'){
    JSTest::set('autoLoadComponentCase',false);
}else{
    JSTest::set('autoLoadComponentCase',true);
}


$router = new JSTest_Router();
$command = P::get('jstest');

$router->switchTo($command);
