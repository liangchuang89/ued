<?php
/**
 * 命令模式实现
 * @author 宇山<yushan.yk@taobao.com>
 * @package interfaces
 */
interface ICommand
{

    /**
     * 命令执行
     * @abstract
     * @return mixed
     */
    public function excute();
}
