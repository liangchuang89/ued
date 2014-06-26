<?php
/**
 * 获取组件默认的模板
 * <br>创建于13-1-17，下午9:16
 * @author 宇山<yushan.yk@taobao.com>
 * @package base
 */
class DefaultTpl implements ITpl
{

    /**
     * @inheritdoc
     */
    public function getTpl($key,$path)
    {
        $tplpath = $path;
        if(file_exists($tplpath)){
            $tpl = file_get_contents($tplpath);
            return $tpl;
        }else{
            L::e($key."对应的文件：".$tplpath."不存在");
        }
        return 0;
    }
}
