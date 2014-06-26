<?php
/**
 * 获取组件模板的接口
 * <br>创建于13-1-17，下午9:14
 * @author 宇山<yushan.yk@taobao.com>
 * @package interfaces
 */
interface ITpl
{
    /**
     * 获取组件模板
     * @param $key 键名，相当于组件的唯一标识
     * @param $path 组件的绝对路径
     * @return string 组件模板
     */
    public function getTpl($key,$path);
}
