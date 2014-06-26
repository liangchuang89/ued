<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class Func_tms {
    /**
     * tms方法
     * @param $prepareUrl 预发地址
     * @param $publishUrl 发布地址
     * @param $isgbk 是否是GBK编码，默认为true
     * @return mixed
     */
    public function tms($prepareUrl,$publishUrl,$isgbk = true){
        C::f('e')->dispatch(new CommonEvent(
            CommonEvent::TMS,
            array($prepareUrl,$publishUrl)
        ));

        if(P::get("mode") == "dev"){
            $tmsUrl = $prepareUrl;
        }else{
            $tmsUrl = $publishUrl;
        }

        if($isgbk){
            return CommonUtils::preReturn(
                $tmsUrl,
                CommonUtils::MODE_ECHO_GBKFILE);
        }else{
            return CommonUtils::preReturn(
                $tmsUrl,
                CommonUtils::MODE_ECHO_FILE);
        }
    }
}
