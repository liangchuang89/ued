<?php
/**
 * 插件管理器接口
 * <br>创建于13-1-30，下午8:47
 * @author 宇山<yushan.yk@taobao.com>
 * @package interfaces
 */
interface IPluginManager
{
    /**
     * 初始化插件
     */
    public function initPlugins();
    /**
     * 添加一个插件
     * @param IPlugin $plugin
     */
    public function addPlugin(IPlugin $plugin);

    /**
     * 移除一个插件
     * @param $name
     */
    public function removePlugin($name);

    /**
     * 判断是否包含某个插件
     * @param $name
     * @return bool
     */
    public function hasPlugin($name);
}
