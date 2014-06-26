<?php
/**
 * @author 宇山<yushan.yk@taobao.com>
 */
class phpspwdata implements IData
{

    function getData($name){
        switch($name){
            case 'component':
                $data = '{"arr":[{"name":"NAN"}]}';
                break;
            default:
                $data = null;
        }
        return $data;
    }
}
