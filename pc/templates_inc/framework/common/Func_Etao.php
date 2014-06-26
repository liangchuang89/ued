<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class Func_Etao {
    const ECOMMON_TEMPLATES = "http://groups.demo.taobao.net/etao/ecommon/templates/";
    /**
     * 添加etao通用的assets
     * @param string $kissyversion KISSY的版本号，默认为1.2.0
     * @param string $brixversion Brix的版本号，默认为1.0
     * @param string $product 产品名，默认为index
     * @return array
     */
    public function eassets($kissyversion = "1.2.0", $brixversion = "1.0", $product = 'index'){
        C::f('e')->dispatch(new CommonEvent(
            CommonEvent::EASSETS,
            array($kissyversion, $brixversion, $product)
        ));

        $assetspath = self::ECOMMON_TEMPLATES."assets/".$product.".php"."?kissyversion=".$kissyversion."&brixversion=".$brixversion;

        return CommonUtils::preReturn(
            $assetspath,
            CommonUtils::MODE_ECHO_FILE);
    }

    /**
     * 添加etao通用的页头
     * @param string $product 文件名，默认为default
     * @return array
     */
    public function eheader($product = 'default'){
        C::f('e')->dispatch(new CommonEvent(
            CommonEvent::EASSETS,
            array($product)
        ));

        $headerpath = self::ECOMMON_TEMPLATES."header/".$product.'.php';

        return CommonUtils::preReturn(
            $headerpath,
            CommonUtils::MODE_ECHO_FILE);
    }

    /**
     * 添加etao通用页尾
     * @param string $product 文件名，默认为index
     * @return array
     */
    public function efooter($product = 'index'){
        C::f('e')->dispatch(new CommonEvent(
            CommonEvent::EASSETS,
            array($product)
        ));

        $footerpath = self::ECOMMON_TEMPLATES."footer/".$product.'.php';

        return CommonUtils::preReturn(
            $footerpath,
            CommonUtils::MODE_ECHO_FILE);
    }

}
