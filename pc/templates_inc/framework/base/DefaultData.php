<?php
/**
 * 获取组件的默认数据
 * @author 宇山<yushan.yk@taobao.com>
 * @package base
 */
class DefaultData implements IData
{

    /**
     * @inheritdoc
     */
    public function getData($key,$path)
    {
        $datapath = $path;
        if(file_exists($datapath)){
            $data = file_get_contents($datapath);
            return $data;
        }
        return 0;
    }
}
