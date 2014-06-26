<?php
define('ROOT',realpath('.'));                                   //网站根目录,比如tsrp库,会指向path/to/tsrp的绝对路径
preg_match('/[^\/(\\\)]+$/',ROOT,$external_repo_name);          //从网站根目录找到当前使用templates_inc的仓库的名称
define('REPO_NAME',$external_repo_name[0]);                     //使用templates_inc的库的仓库名
define('INC', dirname(__FILE__));                               //templates_inc的库的根路径
//从当前路径中找到当前templates_inc所在的文件目录的名称
preg_match('/[^\/(\\\)]+$/', INC, $incname);
define('INC_NAME',$incname[0]);                      //template_inc库所在的目录名称
define('ASSETS','http://g.12lou.org/');              //assets的目录，指向http://assets.etao.net/apps/e/
define('CDN','http://g.tbcdn.cn/etao/');                      //assets的目录，指向http://assets.etao.net/apps/e/


/*自动加载类,用于加载类文件*/
include_once INC.'/framework/autoload.php';
$ti_autoloader = new TI_Autoloader();
/**
 * TODO commands包如果膨胀且并不是所有类都用到，则转移到auto中去
 */
$ti_autoloader->add(array(
    'default'=>array('interfaces','core','common','commands'),
    'auto'=>array('event','base')
));

/*环境初始化*/
C::init(array(
    //添加默认的外观
    'facade' => array(
        'e' => array(
            'description' => '事件模型',
            'module' => new EventDispatcher()
        ),
        'pm' => array(
            'description' => '插件管理，pm是PluginManager的简写',
            'module' => new PluginManager()
        ),
        '3f' => array(
            'description' => '第三方的工具',
            'module' => new ThirdParty()
        )
    ),
    'main' => new MainCommand(array(
//        'get' => array(
//            'jstest'=>'ui',
//            'page'=>'kissyconfig'
//        ),
        //配置插件,插件只能有一个触发的参数，而且不要调用一样的参数
        'plugins' => array(
            'jstest' => array(
                'trigger' => 'jstest',
                'description' => 'js单元测试'
            ),
            'brixcom' => array(
                'trigger' => 'brixcom',
                'description' => '查看单个组件插件启动所需触发的$_GET参数'
            ),
            'codeviewer' => array(
                'trigger' => 'viewsource',
                'use' => array('page','component'),
                'description' => '查看源码插件启动所需触发的$_GET参数'
            ),
            'm2j' => array(
                'trigger' => 'm2j',
                'description' => '生成json数据插件启动所需触发的$_GET参数'
            ),
            'logviewer' => array(
                'trigger' => 'log',
                'description' => '查看日志插件启动所需触发的$_GET参数'
            )
        )
    ))
));

