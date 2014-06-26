<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class Func_KISSY {

    /**
     * 生成KISSY的config
     * @param $version 版本号
     * @param $notLink 不是一个链接
     * @return mixed
     */
    public function kissy_config($version, $notLink = false)
    {
        C::f('e')->dispatch(new CommonEvent(
            CommonEvent::KISSYCONFIG,
            array(
                $version,
                $notLink
            )
        ));
        if($notLink){
            $html = $this->combineAllFile(ROOT.'/src/init');
        }else{
            $html = $this->buildInitFiles($version);
        }

        return CommonUtils::preReturn(
            $html,
            CommonUtils::MODE_ECHO);

    }

    /**
     * 合并输出目录下所有的文件
     * @param $dir
     * @return string
     */
    public function combineAllFile($dir){
        $result = "";
        $files = scandir($dir);
        foreach($files as $file){
            $result .= file_get_contents($dir.'/'.$file);
        }


        return C::f('html')->scriptTag($result);
    }

    /**
     * 启动页面必须要执行的方法
     * @TODO 这个方法目前还不在使用
     * @param $version 时间戳
     * @param $config action配置参数
     * @return mixed
     */
    public function bootpage($version,$config = null){
        C::f('e')->dispatch(new CommonEvent(
            CommonEvent::BOOTPAGE
        ));
        $html = $this->buildInitFiles($version);

        if($config && is_array($config) && array_key_exists('style',$config)) $html .= $this->importStyle($config['style'],$version);

        return CommonUtils::preReturn(
            $html,
            CommonUtils::MODE_ECHO);
    }

    /**
     * 构建与assets上的init.js对应的辅助文件
     * @param $version
     * @return string
     */
    public function buildInitFiles($version){
        if(P::get('mode') == 'dev'){
            $html = C::f('html')->commentTag('以下生成的imports-style.js的标签，package配置，引入的src下的init都为dev情况，请不要让开发童鞋加入这段HTML的源码');
            $html .= C::f('html')->jsScriptTag('http://assets.etao.net/apps/e/kissy/import-style.js');
            $html .= C::f('html')->scriptTag("KISSY.config({combine:false,packages:[{name:'components',debug:true,path: '.'}]});");
            $initjs = C::f('filepack')->trans2dev('src/init','js');
            //假如src下存在init目录
            if(count($initjs)){
                foreach ($initjs as $jsfile) {
                    $html .= C::f('html')->jsScriptTag($jsfile, P::get('nocache'));
                }
            }
        }else{
            $html = C::f('html')->jsScriptTag(C::f('filepack')->trans2assets('src/init', $version, "js", CommonUtils::utils()->getAssetsUrl()));
        }
        return $html;
    }

    /**
     * 模拟KISSY的importStyle方法
     * @TODO 这个方法目前还不在使用
     * @param $style
     * @param $version
     * @return mixed
     */
    public function importStyle($style,$version){
        $style = preg_replace('/^\s*/','components/',$style);
        $module = preg_replace('/,\s*/',',components/',$style);

        if(P::get('mode') == 'dev'){
            $csstag = C::f('html')->cssStyleTag(C::f('filepack')->trans2dev($module,"css"));
        }else{
            $csstag = C::f('html')->cssLinkTag(C::f('filepack')->trans2assets($module,$version,"css", CommonUtils::utils()->getAssetsUrl()));
        }
        return $csstag;
    }

}
