<?php
/**
 * 事件派发器接口
 * <br>创建于13-1-8，下午3:41
 * @author 宇山<yushan.yk@taobao.com>
 * @package interfaces
 */
interface IEventDispatcher
{
    /**
     * 派发一个事件
     * @param IEvent $event
     */
    public function dispatch(IEvent $event);

    /**
     * 添加事件监听器
     * @param $eventType
     * @param $listener
     */
    public function addListener($eventType,$listener);

    /**
     * 移除事件监听器
     * @param $eventType
     * @param $listener
     */
    public function removeListener($eventType,$listener);

    /**
     * 是否有某个事件的监听器
     * @param $eventType
     * @param $listener
     */
    public function hasListener($eventType,$listener);
}
