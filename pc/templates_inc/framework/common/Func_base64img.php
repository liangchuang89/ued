<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class Func_base64img {
    /**
     * @param $imgpath 图片地址
     * @return array
     */
    public function base64img($imgpath){
        if(!file_exists(ROOT.'/'.$imgpath)) return;

        $imgStr = file_get_contents(ROOT.'/'.$imgpath);

        $base64Str = chunk_split(base64_encode($imgStr));
        $base64Str = "data:image/gif;base64,".$base64Str;
        $result = C::f('html')->imgTag($base64Str);
        return CommonUtils::preReturn(
            $result,
            CommonUtils::MODE_ECHO);
    }
}
