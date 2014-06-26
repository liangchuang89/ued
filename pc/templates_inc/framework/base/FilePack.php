<?php
/**
 * 模拟打包的过程
 * @author 宇山<yushan.yk@taobao.com>
 * @package base
 */
class FilePack implements IFliePack
{
    private $root;
    private $repoName;
    function __construct($config)
    {
        $this->root = $config["root"];
        $this->repoName = $config["repoName"];
    }

/// Public Functions ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * @inheritdoc
     */
    public function trans2dev($path, $filetype)
    {
        $result = array();
        $subpaths = $this->prepare($path);
        foreach ($subpaths as $subpath) {
            $func = $this->match($subpath);
            if(!$func){
                L::e($subpath."这个路径不符合打包规则。");
                continue;
            }
            $result = array_merge($result,$this->transform($func[self::DEV],array($subpath,$filetype)));
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function trans2assets($path, $version, $filetype, $url)
    {
        $result = array();
        $subpath = $this->prepare($path);
        $version = $this->prepare($version);
        for($i = 0,$l = count($subpath);$i < $l; $i++){
            $func = $this->match($subpath[$i]);
            if(!$func){
                L::e($subpath[$i]."这个路径不符合打包规则。");
                continue;
            }
            if(array_key_exists($i,$version)) $v = $version[$i];
            array_push($result,$this->transform($func[self::ASSETS],array($subpath[$i],$v,$filetype)));
        }

        return $this->getFullAssetsPath($result, $url);
    }

/// Private Functions ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //匹配哪一条规则，则返回对应规则响应函数的数组包含dev和assets
    private function match($path){
        foreach ($this->rules as $rule => $func) {
            if(preg_match($rule,$path)) return $func;
        }
        return 0;
    }

    //执行转换函数
    private function transform($func,$args){
        return call_user_func_array(array($this,$func),$args);
    }

    //预处理子字符串，比如去除空格
    private function prepare($str)
    {
        $nstr = preg_replace("/\s/","",$str);
        return explode(",",$nstr);
    }

    //打包的规则 TODO: 规则膨胀再进行重构
    private $rules = array(
        "/^src\/[^_\/]+/"               => array("getSrcFiles",                 "trans2SrcAssets"),
        "/^src\/_[^\/]+_/"              => array("formatSrcIgnoreFile",         "trans2SrcAssets"),
        "/^components$/"                => array("getComponentsFiles",          "trans2ComponentsAssets"),
        "/^components\/[^\/]+/"         => array("formatComponentsFile",        "trans2ComponentsFileAssets"),
        "/^imports$/"                   => array("getImportsFiles",             "trans2ComponentsAssets"),
        "/^imports\/[^\/]+\/[^\/]+/"    => array("formatComponentsFile",        "trans2ComponentsFileAssets")
    );

    const DEV = 0;
    const ASSETS = 1;

    //获取imports下相应某种类型的文件的数组
    private function getImportsFiles($path, $filetype){
        $icoms = scandir($this->root.'/imports');
        $importsFileArr = array();
        foreach($icoms as $importsnamespace)
            $importsFileArr = array_merge($importsFileArr,$this->getComponentsFiles('imports/'.$importsnamespace,$filetype));

        return $importsFileArr;
    }
    //获取components下相应某种类型的文件的数组
    private function getComponentsFiles($compdir,$filetype){
        //所选择的文件
        $cfiles = array();
        $files = scandir($this->root.'/'.$compdir);

        foreach ($files as $file) {
            $relativePath = $compdir.'/'.$file.'/index.'.$filetype;
            if($this->isIgnore($this->root.'/'.$relativePath)){
                array_push($cfiles,$relativePath);
            }
        }
        return $cfiles;
    }

    private function isIgnore($path){
        if(preg_match("/_[^\/]+_\/index/",$path)) return false;
        if(!file_exists($path)) return false;

        return true;
    }
    //获取src某个目录下相应某种类型的文件的数组
    private function getSrcFiles($dir,$filetype){
        //所选择的文件
        $cfiles = array();
        $path = $this->root.'/'.$dir;
        if(is_dir($path)){
            $files = scandir($path);
            foreach ($files as $file)
                if(preg_match("/\.".$filetype."$/",$file))
                    array_push($cfiles,$dir.'/'.$file);
        }


        return $cfiles;
    }
    //格式化src下被忽略的文件路径，比如src/_ss_/ss变为components/_ss_/ss.js
    private function formatSrcIgnoreFile($path,$filetype){
        if(!preg_match("/\.".$filetype."$/",$path)) $path .= ".".$filetype;
        return array($path);
    }
    //格式化components或imports下被忽略的组件的文件路径，比如components/_ss_变为components/_ss_/index.js
    private function formatComponentsFile($path,$filetype){
        if(!preg_match("/index\.".$filetype."$/",$path)) $path .= "/index.".$filetype;
        return array($path);
    }
    //将components或imports转换为assets相对路径
    private function trans2ComponentsAssets($path,$version,$filetype){
        return $version."/".$path."/".$path.".".$filetype;
    }
    //将src目录下文件路径转换为assets相对路径
    private function trans2SrcAssets($path, $version, $filetype)
    {
        $path = str_replace('src',$version,$path);
        if(!preg_match("/\.".$filetype."$/",$path)) $path .= ".".$filetype;
        return $path;
    }
    //将components或imports目录下被打包忽略的文件路径转换为assets相对路径
    private function trans2ComponentsFileAssets($path, $version, $filetype){
        if(!preg_match("/index\.".$filetype."$/",$path)) $path .= "/index.".$filetype;
        return $version."/".$path;
    }

    //返回assets绝对路径
    private function getFullAssetsPath($path, $url){
        if(count($path) == 1)
            $href = $url.$this->repoName."/".$path[0];
        else
            $href = $url.$this->repoName."/??".join($path, ',');
        return $href;
    }
}
