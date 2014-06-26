<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class Func_add {
    /**
     * 添加PHP模块<br/>
     * 替换原来的include方法,根据$file找当前templates目录下的具体文件。
     * @param $file 文件相对页面目录的路径
     * @return mixed
     */
    public function add($file){
        C::f('e')->dispatch(new CommonEvent(
            CommonEvent::ADD,
            array($file)
        ));

        $pagedir = ROOT."/templates/".P::get("page");

        if(!preg_match("/\.[^\/]+$/", $file)) $file = $file.'.php';
        $afile = $pagedir.'/'.$file;

        return CommonUtils::preReturn(
            $afile,
            CommonUtils::MODE_INCLUDE);
    }
}
