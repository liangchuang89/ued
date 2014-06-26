<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */

include_once 'thirdparty/pclzip.lib.php';
$publishFile = 'service/publish/131112.zip';

unlink($publishFile);
$build = new PclZip($publishFile);
$build->add('framework/');
$build->add('plugins/');
$build->add('thirdparty/');
$build->add('index.php');