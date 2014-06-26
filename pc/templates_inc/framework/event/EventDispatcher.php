<?php
/**
 * 事件管理器
 * <br>创建于13-1-8，下午3:32
 * @author 宇山<yushan.yk@taobao.com>
 * @package event
 */
class EventDispatcher implements IEventDispatcher
{
    private $listenerQueue = array();

    /**
     * @inheritdoc
     */
    function dispatch(IEvent $event)
    {
        if(!isset($this->listenerQueue[$event->type()])) return;
        foreach ($this->listenerQueue[$event->type()] as $listener) {
            if(is_array($listener)){
                call_user_func($listener,$event);
            }else{
                L::e("监听器不正确");
            }
        }
    }

    /**
     * @inheritdoc
     */
    function addListener($eventType, $listener)
    {
        if(!array_key_exists($eventType,$this->listenerQueue))
            $this->listenerQueue[$eventType] = array();
        array_push($this->listenerQueue[$eventType],$listener);
    }

    /**
     * @inheritdoc
     */
    function removeListener($eventType, $listener)
    {
        foreach ($this->listenerQueue[$eventType] as $k => $l) {
            if($listener === $l){
                array_splice($this->listenerQueue[$eventType],$k,1);
            }
        }

    }

    /**
     * @inheritdoc
     */
    function hasListener($eventType, $listener)
    {
        foreach ($this->listenerQueue[$eventType] as $l) {
            if($listener === $l)
                return true;
        }
        return false;
    }
}
