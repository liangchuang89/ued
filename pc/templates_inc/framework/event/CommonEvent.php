<?php
/**
 * 通用函数触发的事件
 * <br>创建于13-1-30，下午4:46
 * @author 宇山<yushan.yk@taobao.com>
 * @package event
 */
class CommonEvent extends TIEvent
{
    const ADD         = "common_add";
    const COMPONENTS  = "common_components";
    const CSS         = "common_css";
    const JS          = "common_js";
    const EASSETS     = "common_eassets";
    const EHEADER     = "common_eheader";
    const EFOOTER     = "common_efooter";
    const KISSYCONFIG = "common_kissy_config";
    const BOOTPAGE    = "common_bootpage";
    const TMS         = "common_tms";
}
