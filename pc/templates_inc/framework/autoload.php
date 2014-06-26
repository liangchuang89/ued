<?php
/**
 * 自动加载类
 * 例子：
 * <pre>
 * //无参数，则默认根路径为autoload.php文件所在目录的绝对路径
 * $ti_autoloader = new TI_Autoloader();
 * //也可以手动设置一个根路径
 * //$ti_autoloader = new TI_Autoloader('/user/dd');
 * $ti_autoloader->add(array(
 *  "default"=>array("core","event","common"),//默认的包，会加载这些包下的所有文件
 *  "auto"=>array("base")//autoload机制要遍历的包，这个包下的类实例化的时候会自动加载
 * ));
 * </pre>
 * 创建于13-1-8，下午1:42
 * @author 宇山<yushan.yk@taobao.com>
 */
class TI_Autoloader{

    private $basePath;//加载的根路径
    private $autoLoadPath;//autoload要遍历的目录的数组

    /**
     * @param null $basePath 默认为当前autoload.php所在目录的绝对路径
     */
    function __construct($basePath = null){
        if(!$basePath) $basePath = dirname(__FILE__);
        $this->basePath = $basePath;

    }

    /**
     * 添加包
     * @param $package
     */
    public function add($package){
        if(array_key_exists('default',$package)) $this->loadDefaultClasses($package['default']);
        if(array_key_exists('auto',$package)) $this->initAutoLoadClasses($package['auto']);
    }

    //加载默认的类文件
    private function loadDefaultClasses($packages){
        foreach ($packages as $package) {
            $packagepath = $this->basePath.'/'.$package;
            $classes = scandir($packagepath);
            foreach ($classes as $classfile) {
                $phpfile = $packagepath.'/'.$classfile;
                if($this->isPHPFile($phpfile)){
                    include_once $phpfile;
                }
            }
        }
    }
    private function isPHPFile($file){
        if(is_file($file) && preg_match("/\.php$/",$file)) return true;
        else return false;
    }
    //初始化自动加载机制要遍历的目录
    private function initAutoLoadClasses($packages)
    {
        $this->autoLoadPath = array();
        foreach ($packages as $package) {
            array_push($this->autoLoadPath,$this->basePath.'/'.$package.'/');
        }
        spl_autoload_register(array($this,'autoload'));
    }
    //自动加载机制实现
    private function autoload($className){
        foreach ($this->autoLoadPath as $path) {
            $classfile = $path.$className.'.php';
            if(file_exists($classfile)){
                include_once $classfile;
                return;
            }
        }
    }
}

