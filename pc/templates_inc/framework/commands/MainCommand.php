<?php
/**
 * 主线命令，控制总的PHP运行流程
 * <h3>构造函数配置的作用</h3>
 * <pre>
 * array(
 * 	'get' => array('log'=>1),
 * 	//配置插件,插件只能有一个触发的参数，而且不要调用一样的参数
 * 	'plugins' => array(
 * 		'codeviewer' => array(
 *          'trigger' => 'viewsource',
 *          'use' => array('page','component'),
 *          'description' => '查看源码插件启动所需触发的$_GET参数'
 *      )
 * 	 )
 * )
 * </pre>
 * <code>get</code>会在P::initGetPatm时使用，用来替换$_GET参数。<br>
 * <code>plugins</code>配置插件启动项：<br>
 * <ul>
 * <li>trigger:插件触发的参数</li>
 * <li>use:插件都使用了那些参数</li>
 * <li>description:插件作用描述</li>
 * </ul>
 * <br>创建于13-1-10，下午7:46
 * @author 宇山<yushan.yk@taobao.com>
 * @package commands
 */
class MainCommand implements ICommand
{
    private $config;

    function __construct($config){
        $this->config = $config;
    }

    /**
     * @inheritdoc
     */
    public function excute(){
        /*初始化$_GET参数*/
        $get = null;
        if(array_key_exists('get',$this->config)) $get = $this->config['get'];

        /*添加默认执行参数*/
        P::set("mode","assets");
        P::set("render","php");
        P::set("page","index");

        P::initGETParam($get);

        $this->bootPlugins($this->config['plugins']);
        C::f('pm')->initPlugins();
        $this->renderPage();
    }
    //启动插件配置
    private function bootPlugins($config)
    {
        if(!$config) return;
        foreach ($config as $plugin => $config) {
            if(P::get($config['trigger'])){
                include INC."/plugins/".$plugin."/main.php";
            }
        }

    }
    //开始渲染页面
    private function renderPage()
    {
        $page = P::get("page");
        $pagepath = ROOT."/templates/".$page;
        if(!file_exists($pagepath)) L::e($page."页面不存在！");


        C::f('e')->dispatch(new MCEvent(MCEvent::RENDER));
        /*初始化组织页面的工具*/
        //选择一个渲染器
        switch(P::get("render")){
            case "js":
                C::registerFacade('render', 'JS的渲染器', new JSRender());
                break;
            default:
                C::registerFacade('render', 'PHP的渲染器', new PHPRender(C::f('3f')->getMustacheRender()));
        }

        //选择一个数据源
        if(P::get("usedata")){
            include_once $pagepath."/data.php";
            $classname = str_replace("-","",$page).'data';
            C::registerFacade('data', '自定义的数据', new $classname());
        }else{
            C::registerFacade('data', '默认的数据', new DefaultData());
        }

        //选择一种模板
        C::registerFacade('tpl', '默认的模板', new DefaultTpl());
        //将HTMLTag实例添加到外观
        C::registerFacade('html','HTML输出标签的模块',new HTMLTag());
        //将FilePack添加到外观
        C::registerFacade(
            'filepack',
            '模拟打包的模块',
            new FilePack(array(
                "root" => ROOT,
                "assets" => ASSETS,
                "cdn" => CDN,
                "repoName" => REPO_NAME
            ))
        );

        //初始化通用函数
        CommonUtils::setUp();

        include $pagepath."/index.php";
        $this->addUtilsTool();
        C::f('e')->dispatch(new MCEvent(MCEvent::RENDERED));


    }

    private function addUtilsTool(){

        //输出二维码
        echo <<<EOB
<script>
console.log("%c  ","font-size:180px;background:url('https://chart.googleapis.com/chart?cht=qr&chs=200x200&choe=UTF-8&chld=L|4&chl=" + window.location.href +"') no-repeat 0 0");

</script>
EOB;
        $this->checkUpdate();
    }

    private function checkUpdate(){
        if(P::get('nocheckupdate')) return;
        if(file_exists("http://groups.demo.taobao.net/ux/templates_inc/package.json") && file_exists(INC.'/package.json')){

            $newPackage = json_decode(file_get_contents("http://groups.demo.taobao.net/ux/templates_inc/package.json"), true);
            $currentPackage = json_decode(file_get_contents(INC.'/package.json'));
            if($currentPackage['version'] !== $newPackage['version']){
                echo <<<EOB
<script>
alert("你所使用的templates_inc不是最新版本，请更新submodule，更新说明请查看http://groups.demo.taobao.net/ux/templates_inc");
</script>
EOB;
            }
        }
    }
}
