<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class JSTest_UnitTestRunner {
    public function run(){
        $render = C::f('3f')->getMustacheRender();
        $data = array(
            "jasminepath"=>INC_NAME."/thirdparty/jasmine",
            "specsRoot"=>"test/",
            "jstestAssets"=>INC_NAME."/plugins/jstest/assets"
        );
        $data['packages'] = array();

        $packages = scandir(JSTest::get('testRoot'));
        foreach ($packages as $package) {
            $this->seekSpec($package);
            if(count($this->specsMap) && $package != 'templates'){
                array_push($data['packages'],array(
                    'package' => $package,
                    'jsfiles' => $this->specsMap
                ));

                $this->specsMap = array();
            }
        }

        $template = file_get_contents(JSTest::get('basePath')."/assets/runner.html");

        echo $render->render($template,$data);
    }

    private $specsMap = array();

    public function seekSpec($path){
        if(preg_match('/\.+$/',$path)) return;

        if(is_dir(JSTest::get('testRoot').'/'.$path)){
            if($path != '') $path .= '/';
            $files = scandir(JSTest::get('testRoot').'/'.$path);
            foreach ($files as $file) {
                $this->seekSpec($path.$file);
            }
        }else{
            $spechashmap = array();
            $isjsfile = preg_match('/\.js+$/',$path);
            if($isjsfile){
                $spechashmap['test'] = str_replace('.js','',$path);
            }
            if($isjsfile && file_exists(JSTest::get('repoRoot').'/'.$path)){
                $spechashmap['source'] = str_replace('.js','',$path);
            }
            if($isjsfile) array_push($this->specsMap,$spechashmap);
        }
    }
}
