<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class JSTest_Router {
    public function switchTo($command){
        if($command == 'r'){
            $unitTestRunner = new JSTest_UnitTestRunner();
            $unitTestRunner->run();

            exit;
        }
        else if(preg_match('/^uir$/',$command,$match)){
            $uirtestRunner = new JSTest_UIResponseTestRunner();
            $uirtestRunner->run();
            exit;
        }
        else if(preg_match('/^ui$/',$command,$match)){
            $uitestRunner = new JSTest_UITestRunner();
            C::f('pm')->addPlugin($uitestRunner);
        }
        else if(preg_match('/g\:([^\:]+)?\:?([^\:]+)?/',$command,$match)){
            $specGenerator = new JSTest_SpecGenerator();
            $path = isset($match[1]) ? $match[1]:'components';
            $control = isset($match[2]) ? $match[2] : 'all';
            $specGenerator->generate($path,$control);

            exit;
        }
    }
}
