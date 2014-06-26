<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class JSTest_UIResponseTestRunner {
    public function run(){
        $render = C::f('3f')->getMustacheRender();
        $data = array(
            "jasminepath"=>INC_NAME."/thirdparty/jasmine",
            "jstestAssets"=>INC_NAME."/plugins/jstest/assets"
        );
        $data['packages'] = array();
        $uri = $_SERVER['REQUEST_URI'];
        $uri = str_replace('jstest=uir','jstest=ui',$uri);
        $data['iframePath'] = $uri;

        $template = file_get_contents(JSTest::get('basePath')."/assets/uiindex.html");

        echo $render->render($template,$data);
    }
}
