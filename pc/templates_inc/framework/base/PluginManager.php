<?php
/**
 * 插件管理
 * <br>创建于13-1-30，下午7:58
 * @author 宇山<yushan.yk@taobao.com>
 * @package base
 */
class PluginManager implements IPluginManager
{
    private $pluginPool = array();
    /**
     * @inheritdoc
     */
    public function addPlugin(IPlugin $plugin)
    {
        $name = $plugin->name();
        if(!array_key_exists($name,$this->pluginPool)) $this->pluginPool[$name] = $plugin;
    }

    /**
     * @inheritdoc
     */
    public function removePlugin($name)
    {
        if(array_key_exists($name,$this->pluginPool)){
            if($this->pluginPool[$name]->isInit()) $this->pluginPool[$name]->destroy();
            unset($this->pluginPool[$name]);
        }
    }

    /**
     * @inheritdoc
     */
    public function hasPlugin($name)
    {
        return array_key_exists($name,$this->pluginPool);
    }

    /**
     * @inheritdoc
     */
    public function initPlugins()
    {
        foreach ($this->pluginPool as $plugin) {
            $plugin->init();
            C::f('e')->dispatch(new PluginEvent(PluginEvent::INIT,array('pluginName'=>$plugin->name())));
        }
    }
}
