<?php
/**
 * 渲染器接口，约束渲染器行为
 * @author 宇山<yushan.yk@taobao.com>
 * @package interfaces
 */
interface IRender
{
    /**
     * 实现模板与数据的渲染
     * @abstract
     * @param $tpl 模板
     * @param $data 数据
     * @param $key 索引，也就是componets和imports的方法的第一个参数的值
     * @return string
     */
    public function render($tpl,$data,$key);
}
