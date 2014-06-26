<?php
/**
 * 插件接口
 * <br>创建于13-1-8，下午3:29
 * @author 宇山<yushan.yk@taobao.com>
 * @package interfaces
 */
interface IPlugin
{
    /**
     * 返回插件的目录名
     * @return string
     */
    public function name();
    /**
     * 插件初始化
     */
    public function init();

    /**
     * 是否已经初始化
     * @return bool
     */
    public function isInit();
    /**
     * 插件销毁
     */
    public function destroy();
}
