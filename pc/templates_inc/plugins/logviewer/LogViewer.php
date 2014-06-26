<?php
/**
 * 创建于13-2-5，下午12:25
 * @author 宇山<yushan.yk@taobao.com>
 */
class LogViewer implements IPlugin
{
    private $isinit = false;
    private $basePath;

    function __construct()
    {
        $this->basePath = dirname(__FILE__);
    }

    /**
     * @inheritdoc
     */
    public function name()
    {
        return 'logviewer';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        C::f('e')->addListener(MCEvent::RENDER,array($this,"addLogPanel"));
        C::f('e')->addListener(MCEvent::RENDERED,array($this,"addLogControlPanel"));

        $this->isinit = true;
    }

    public function addLogPanel($e)
    {
        if(!isset($_POST['getjson'])) return;

        $render = C::f('3f')->getMustacheRender();

        $content = $_POST["getjson"];
        $mpost = json_decode($content,true);
        //var_dump($post);exit;
        $data = array("item"=>array());//渲染所需数据
        //记录当前页面
        if(array_key_exists('component',$mpost))
            $data["current"] = 'component='.$mpost['component'];
        else if(array_key_exists('page',$mpost)){
            $data["current"] = 'page='.$mpost["page"];
        }
        //处理L::r中记录的数据
        foreach($mpost["logmap"]["record"] as $key => $karr){
            $item = array();
            $item["category"] = $key;
            $item["list"] = array();
            foreach($karr as $value){
                array_push($item["list"],array("content"=>$value));
            }
            array_push($data["item"],$item);
        }
        $html = $render->render(file_get_contents($this->basePath.'/getparam.html'),$data);
        echo $html;
        exit;
    }

    public function addLogControlPanel($e){
        $log = L::o();
        $idata = array(
            'logmap' =>$log
        );
        if(P::get('page')) $idata['page'] = P::get('page');
        if(P::get('component')) $idata['component'] = P::get('component');

        $data = array("data" =>json_encode($idata));
        //输出单个组件渲染后的结果
        $render = C::f('3f')->getMustacheRender();
        $html = $render->render(file_get_contents($this->basePath.'/logrecord.html'),$data);
        echo $html;
    }

    /**
     * @inheritdoc
     */
    public function isInit()
    {
        return $this->isinit;
    }

    /**
     * @inheritdoc
     */
    public function destroy()
    {
        C::f('e')->removeListener(MCEvent::RENDER,array($this,"addLogPanel"));
        C::f('e')->removeListener(MCEvent::RENDERED,array($this,"addLogControlPanel"));

        $this->isinit = false;
    }
}
