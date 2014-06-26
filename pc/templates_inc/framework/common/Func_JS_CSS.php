<?php
/**
 * @author 宇山<yushan.yk@taobao.com>
 */
class Func_JS_CSS {
    /**
     * 加载css文件
     * @param $module 模块名称
     * @param string $version 版本号
     * @return array
     */
    public function css($module, $version = '') {
        C::f('e')->dispatch(new CommonEvent(
            CommonEvent::CSS,
            array($module,$version)
        ));

        if($version){
            if(P::get('mode') == 'dev'){
                $csstag = C::f('html')->cssStyleTag(
                    C::f('filepack')->trans2dev($module,"css"),
                    P::get('nocache')
                );
            }else{
                $csstag = C::f('html')->cssLinkTag(
                    C::f('filepack')->trans2assets(
                        $module,
                        $version,
                        "css",
                        CommonUtils::utils()->getAssetsUrl()
                    )
                );
            }
        }else{
            $csstag = C::f('html')->cssLinkTag($module);
        }

        return CommonUtils::preReturn(
            $csstag,
            CommonUtils::MODE_ECHO);
    }

    /**
     * 添加js模块
     * @param $module 模块名称
     * @param string $version 版本号
     * @return array
     */
    public function js($module, $version = '') {
        C::f('e')->dispatch(new CommonEvent(
            CommonEvent::JS,
            array($module,$version)
        ));

        if($version){
            if(P::get('mode') == 'dev'){
                $jstag = "";
                foreach (C::f('filepack')->trans2dev($module, "js") as $jsfile){
                    $jstag .= C::f('html')->jsScriptTag($jsfile, P::get('nocache'));
                }
            }else{
                $jstag = C::f('html')->jsScriptTag(
                    C::f('filepack')->trans2assets(
                        $module,
                        $version,
                        "js",
                        CommonUtils::utils()->getAssetsUrl()
                    ));
            }
        }else{
            $jstag = C::f('html')->jsScriptTag($module);
        }

        return CommonUtils::preReturn(
            $jstag,
            CommonUtils::MODE_ECHO);
    }

}
