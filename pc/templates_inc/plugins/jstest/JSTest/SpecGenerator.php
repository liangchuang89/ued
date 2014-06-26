<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class JSTest_SpecGenerator {
    public function analysisSourceCode($file,$command){
        $result = array('className'=>'TestClass');
        $result['modName'] = str_replace('.js','',$file);

        $file = fopen(JSTest::get('repoRoot').'/'.$file,'r');
        $className = false;
        while(!feof($file) && !$className){
            $lineStr = fgets($file);
            $className = $this->findClassName($lineStr);
        }
        if($className) $result['className'] = $className;
        if($className && $command == 'method'){

            $result['methods'] = array();

            $methodBraceFlag = 0;//{+1,}-1
            $var = $this->findMethodBrace($lineStr);
            $methodBraceFlag = $methodBraceFlag + $var['left'] - $var['right'];
            while($methodBraceFlag){
                $lineStr = fgets($file);
                $var = $this->findMethodBrace($lineStr);
                $methodBraceFlag = $methodBraceFlag + $var['left'] - $var['right'];
                $methodName = $this->findMethodName($lineStr);

                if($methodName){
                    array_push($result['methods'],array('methodName'=>$methodName));
                }
            }

        }

        fclose($file);

        return $result;
    }

    private function findClassName($lineStr){
        if(preg_match('/(\S+)\.METHOD/',$lineStr,$match)){
            return $match[1];
        }else if(preg_match('/(\S+)\.prototype/',$lineStr,$match)){
            return $match[1];
        }else{
            return false;
        }
    }

    private function findMethodBrace($lineStr){
        preg_match_all('/\{/',$lineStr,$matcha);
        preg_match_all('/\}/',$lineStr,$matchb);
        $result = array(
            'left' => 0,
            'right' => 0
        );
        if($matcha) $result['left'] = count($matcha[0]);
        if($matchb) $result['right'] = count($matchb[0]);
        return $result;
    }

    private function findMethodName($lineStr){
        if(preg_match('/(\S+)\:.*function/',$lineStr,$match)){
            return $match[1];
        }else{
            return false;
        }
    }

    public function genetateSpec($analysisResult,$jsfile){
        $render = C::f('3f')->getMustacheRender();
        $specMtpl = file_get_contents(JSTest::get('basePath')."/assets/spec.mtpl");
        $specCode = $render->render($specMtpl,$analysisResult);

        $jsfilePath = JSTest::get('testRoot').'/'.$jsfile;
        if(file_exists($jsfilePath)){
            echo $jsfile."已经存在,如果需要重新生成,请先删除原有文件。<br/>\n";
            return;
        }
        $this->createDir($jsfilePath);

        file_put_contents($jsfilePath,$specCode);

        echo "成功生成{$jsfile}测试文件。<br/>\n";
    }

    public function createDir($path){
        $dir = dirname($path);
        if(!file_exists($dir)){
            $this->createDir($dir);
            mkdir($dir);
        }
    }

    public function generate($path,$command){
        $this->seekJs($path);
        foreach ($this->jsArr as $jsfile) {
            $this->genetateSpec($this->analysisSourceCode($jsfile,$command),$jsfile);
        }

    }

    private $jsArr = array();
    public function seekJs($path){
        if(preg_match('/\.+$/',$path)) return;

        if(is_dir(JSTest::get('repoRoot').'/'.$path)){
            $files = scandir(JSTest::get('repoRoot').'/'.$path);
            foreach ($files as $file) {
                $this->seekJs($path.'/'.$file);
            }
        }else{
            $isjsfile = preg_match('/\.js+$/',$path);
            if($isjsfile){
                array_push($this->jsArr,$path);
            }
        }
    }

}
