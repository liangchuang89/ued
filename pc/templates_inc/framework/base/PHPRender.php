<?php
/**
 * PHP的渲染器
 * @author 宇山<yushan.yk@taobao.com>
 * @package base
 */
class PHPRender implements IRender
{
    private $me;
    function __construct($me = null){
        $this->me = $me;
    }

    /**
     * @inheritdoc
     */
    public function render($tpl, $data, $key){
        return $this->me->render($tpl, $data);
    }

}
