<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class FuncUtils {
    /**
     * 分解路径
     * @param $path
     * @return array
     */
    public function breakPath($path){
        if(preg_match("/[^\/]*html[^\/]*$/", $path, $match)){
            $path = str_replace('/'.$match[0],"", $path);
            return array(Func_components::RETURN_TPL, $path);
        }else if(preg_match("/[^\/]*json[^\/]*$/", $path, $match)){
            $path = str_replace('/'.$match[0],"", $path);
            return array(Func_components::RETURN_DATA, $path);
        }else{
            return array(Func_components::DEFAULT_RENDER, $path);
        }
    }

    /**
     * 返回资源的url前缀
     * @return string
     */
    public function getAssetsUrl(){
        if(P::get('mode') == 'cdn'){
            return CDN;
        }else if(P::get('mode') == 'assets'){
            return ASSETS;
        }else{
            return ASSETS;
        }
    }
}
