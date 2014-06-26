<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class JSTest_UITestRunner implements IPlugin {
    private $isInit = false;
    /**
     * 返回插件的目录名
     * @return string
     */
    public function name()
    {
        return 'uitestpanel';
    }

    /**
     * 插件初始化
     */
    public function init()
    {
        $this->isInit = true;
        C::f('e')->addListener(MCEvent::RENDERED,array($this,'addUITestPanel'));
        C::f('e')->addListener(JSTest_Event::ADD_TESTS,array($this,'addUITestPanel'));
        if(JSTest::get('autoLoadComponentCase')){
            C::f('e')->addListener(CommonEvent::COMPONENTS, array($this, 'addComponentCase'));
        }

        if(JSTest::get('uitestASyncCase')){
            $asyncCases = JSTest::get('uitestASyncCase');
            $finalCases = array();
            foreach ($asyncCases as $asyncMod) {
                array_push($finalCases,'test/components/'.$asyncMod.'/');
            }

            $this->pushCase($finalCases);
        }
    }

    public function addComponentCase($e){
        $componentName = $e->getContent();
        $this->pushCase(array('test/components/'.$componentName[0].'/'));
    }

    private $pageSpecsPath;
    public function addUITestPanel($e){
        C::f('e')->removeListener(MCEvent::RENDERED,array($this,'addUITestPanel'));
        C::f('e')->removeListener(JSTest_Event::ADD_TESTS,array($this,'addUITestPanel'));
        $this->pageSpecsPath = JSTest::get('repoRoot').'/test/templates/';


        $render = C::f('3f')->getMustacheRender();
        $data = array(
            "jasminepath"=>INC_NAME."/thirdparty/jasmine",
            "jstestAssets"=>INC_NAME."/plugins/jstest/assets"
        );
        $template = file_get_contents(JSTest::get('basePath')."/assets/uitestpanel.html");
        $this->seekJs(P::get('page'));
        $data['specs'] = $this->caseArr;

        echo $render->render($template,$data);

    }

    public function pushCase($arr){
        foreach ($arr as $cpn) {
            if(file_exists($cpn.'.js') || file_exists($cpn.'index.js'))
                array_push($this->caseArr,array('test' => $cpn));
        }
    }

    private $caseArr = array();
    public function seekJs($path){
        if(preg_match('/\.+$/',$path)) return;

        if(is_dir($this->pageSpecsPath.$path)){
            $files = scandir($this->pageSpecsPath.$path);
            foreach ($files as $file) {
                $this->seekJs($path.'/'.$file);
            }
        }else{
            $isjsfile = preg_match('/\.js+$/',$path);
            if($isjsfile){
                $this->pushCase(array('test/templates/'.str_replace('.js','',$path)));
            }
        }
    }

    /**
     * 是否已经初始化
     * @return bool
     */
    public function isInit()
    {
        return $this->isInit;
    }

    /**
     * 插件销毁
     */
    public function destroy()
    {

        if(JSTest::get('autoLoadComponentCase')){
            C::f('e')->removeListener(CommonEvent::CSS, array($this, 'addComponentCase'));
        }
        $this->isInit = false;
    }
}
