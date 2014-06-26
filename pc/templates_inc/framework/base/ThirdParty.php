<?php
/**
 * 获取第三方的工具
 * <br>创建于13-3-28，下午4:39
 * @author 宇山<yushan.yk@taobao.com>
 */
class ThirdParty
{
    private $mrender;

    /**
     * 获取mustache的渲染引擎
     * @return Mustache_Engine
     */
    public function getMustacheRender(){
        if(!$this->mrender){
            include_once INC."/thirdparty/Mustache/Autoloader.php";
            Mustache_Autoloader::register();
            $this->mrender = new Mustache_Engine();
        }
        return $this->mrender;
    }
}
