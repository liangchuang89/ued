<?php
/*
 * 全局通用函数声明，具体实现详见Func开头的类
 * 创建于13-1-23，下午2:57
 * @author 宇山<yushan.yk@taobao.com>
 */

/// 组件组织 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function components($file, $config = null){
    return CommonUtils::processReturn(
        CommonUtils::func('components')->components($file, $config)
    );
}
function add($file){
    return CommonUtils::processReturn(
        CommonUtils::func('add')->add($file)
    );
}
function tms($prepareUrl,$publishUrl,$isgbk = true){
    return CommonUtils::processReturn(
        CommonUtils::func('tms')->tms($prepareUrl,$publishUrl,$isgbk)
    );
}


/// css和js方法 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function css($module, $version = '') {
    return CommonUtils::processReturn(
        CommonUtils::func('js_css')->css($module, $version)
    );
}
function js($module, $version = '') {
    return CommonUtils::processReturn(
        CommonUtils::func('js_css')->js($module, $version)
    );
}

function base64img($imgpath) {
    return CommonUtils::processReturn(
        CommonUtils::func('base64img')->base64img($imgpath)
    );
}

/// 添加etao网站通用头尾 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function eassets($kissyversion = "1.2.0", $brixversion = "1.0", $product = 'index'){
    return CommonUtils::processReturn(
        CommonUtils::func('etao')->eassets($kissyversion, $brixversion, $product)
    );
}
function eheader($product = 'default'){
    return CommonUtils::processReturn(
        CommonUtils::func('etao')->eheader($product)
    );
}
function efooter($product = 'index'){
    return CommonUtils::processReturn(
        CommonUtils::func('etao')->efooter($product)
    );
}

/// KISSY的配置 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function kissy_config($version, $notLink = false){
    return CommonUtils::processReturn(
        CommonUtils::func('kissy')->kissy_config($version, $notLink)
    );
}
function bootpage($version,$config = null){
    return CommonUtils::processReturn(
        CommonUtils::func('kissy')->bootpage($version,$config)
    );
}