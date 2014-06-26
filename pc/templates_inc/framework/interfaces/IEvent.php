<?php
/**
 * 事件接口
 * <br>创建于13-1-11，下午2:43
 * @author 宇山<yushan.yk@taobao.com>
 * @package interfaces
 */
interface IEvent
{
    /**
     * 事件类型不可更改，为只读
     * @return mixed
     */
    public function type();

    /**
     * 设置事件的内容
     * @param $content
     * @return mixed
     */
    public function setContent($content);

    /**
     * 获取事件的内容
     * @return mixed
     */
    public function getContent();
}
