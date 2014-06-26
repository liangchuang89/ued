<?php
/**
 * 事件基类
 * <br>创建于13-1-8，下午3:32
 * @author 宇山<yushan.yk@taobao.com>
 * @package event
 */
class TIEvent implements IEvent
{
    protected $type;
    protected $content;

    function __construct($type,$content = null){
        $this->type = $type;
        $this->content = $content;
    }

    /**
     * @inheritdoc
     */
    public function type(){
        return $this->type;
    }

    /**
     * @inheritdoc
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        return $this->content;
    }
}
