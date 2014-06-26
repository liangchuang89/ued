<?php
/**
 * JS的渲染器
 * @author 宇山<yushan.yk@taobao.com>
 * @package base
 */
class JSRender implements IRender
{
    private $compRendered = array();

    /**
     * @inheritdoc
     */
    public function render($tpl, $data, $key)
    {
        $key = str_replace("/","-",$key);
        $key = str_replace(".","-",$key);
        $key = 'J_tpl-'.$key;
        if(array_key_exists($key, $this->compRendered)) return '';
        $html = "<script id=\"".$key."\">";


        $html .= $tpl;

        $html .= "</script>";
        $this->compRendered[$key]= 'rendered';
        return $html;
    }
}
