<?php
/**
 * 创建于13-1-30，下午8:45
 * @author 宇山<yushan.yk@taobao.com>
 */
include_once "CodeViewer.php";

$codeviewer = new CodeViewer();
$render = C::f('3f')->getMustacheRender();
$basePath = dirname(__FILE__);

if(P::get('component')){
    $codeBlocks = $codeviewer->getComponentSourceCode(P::get('component'),P::get('viewsource'));
}else if(P::get('page')){
    $codeBlocks = $codeviewer->getPageSourceCode(P::get('page'),P::get('viewsource'));
}

echo $render->render(file_get_contents($basePath.'/viewsource.html'),$codeBlocks);

exit;