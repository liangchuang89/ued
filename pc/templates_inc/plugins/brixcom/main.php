<?php
/**
 * 创建于13-1-31，下午2:09
 * @author 宇山<yushan.yk@taobao.com>
 */
$render = C::f('3f')->getMustacheRender();

$cpnName = P::get('brixcom');

if(is_dir(ROOT."/components/".$cpnName)) $cpnPath = ROOT."/components/".$cpnName;
else if(is_dir(ROOT."/imports/".$cpnName)) $cpnPath = ROOT."/imports/".$cpnName;
else{
    echo '所选择的组件:'.$cpnName.'不存在';
    exit;
};
$basePath = dirname(__FILE__);

$cpntpl = file_get_contents($cpnPath.'/template.html');
$cpntpl = $cpntpl;

if(file_exists($cpnPath.'/data.json')){
    $cpndata = file_get_contents($cpnPath.'/data.json');
    $cpndata = $cpndata;
    $cpndata = json_decode($cpndata,true);
}else $cpndata = array();

$cpnContent = $render->render($cpntpl,$cpndata);

//输出单个组件渲染后的结果
$data = array();
$data['componentcontent'] = $cpnContent;


if(file_exists($cpnPath.'/index.css')) $data['css'] = 'components/'.$cpnName.'/index.css';
if(file_exists($cpnPath.'/index.js')) $data['js'] = 'components/'.$cpnName.'/index.js';
$html = $render->render(file_get_contents($basePath.'/component.html'),$data);
$html = $html;
echo $html;
exit;