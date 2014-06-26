<?php
/**
 * @author 宇山<yushan.yk@taobao.com>
 */
include_once "../framework/autoload.php";
$ti_autoloader = new TI_Autoloader();
$ti_autoloader->add(array(
    "default"=>array("interfaces","core","commands","base","common"),
    "auto"=>array("event")
));