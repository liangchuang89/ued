<?php
/**
 * @author 宇山<yushan.yk@taobao.com> 
 */ 
class Func_components{
    /*// components方法的方式 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    /**
     * 返回数据
     */
    const RETURN_DATA = 'return_data';
    /**
     * 返回模板
     */
    const RETURN_TPL = 'return_tpl';
    /**
     * 使用默认的数据渲染
     */
    const DEFAULT_RENDER = 'default_render';
    /**
     * 自定义渲染
     */
    const CUSTOM_RENDER = 'custom_render';
    /**
     * 添加组件
     * @param $file 组件的相对路径，比如breadcrumbs就是指components/breadcrumbs
     * @param $config 组件的数据
     * @return int|string 若是html、json，则返回GBK字符串,若是组件渲染成功，则返回1；
     */
    public function components($file,$config = null){
        C::f('e')->dispatch(new CommonEvent(
            CommonEvent::COMPONENTS,
            array($file,$config)
        ));

        $pathArr = CommonUtils::utils()->breakPath($file);
        $mode = $pathArr[0];
        $key = $pathArr[1];
        $componentPath = ROOT.'/components/'.$key;//组件路径
        if($config){
            $mode = isset($config['mode']) ? $config['mode'] : self::CUSTOM_RENDER;
        }
        switch($mode){
            //返回数据
            case self::RETURN_DATA:
                $data_suffix = isset($config['data']) ? '_'.$config['data'] : '';
                $data = C::f('data')->getData($key, $componentPath.'/data'.$data_suffix.'.json');
                return CommonUtils::preReturn(
                    $data,
                    CommonUtils::MODE_DO_NOTHING);

            //执行自定义的渲染行为
            case self::RETURN_TPL:
                $tpl_suffix = isset($config['tpl']) ? '_'.$config['tpl'] : '';
                $tpl = C::f('tpl')->getTpl($key, $componentPath.'/template'.$tpl_suffix.'.html');
                return CommonUtils::preReturn(
                    $tpl,
                    CommonUtils::MODE_DO_NOTHING);

            //执行自定义的渲染行为
            case self::CUSTOM_RENDER:
                if(isset($config['tpl']) && is_array($config['tpl'])){
                    $tpl = join('',$config['tpl']);
                }else{
                    $tpl_suffix = isset($config['tpl']) ? '_'.$config['tpl'] : '';
                    $tpl = C::f('tpl')->getTpl($key, $componentPath.'/template'.$tpl_suffix.'.html');
                }

                if(isset($config['data']) && !is_string($config['data'])){
                    $data = $config['data'];
                }else{
                    $data_suffix = isset($config['data']) ? '_'.$config['data'] : '';
                    $data = C::f('data')->getData($key, $componentPath.'/data'.$data_suffix.'.json');
                    $data = json_decode($data, true);
                }

                return CommonUtils::preReturn(
                    C::f('render')->render($tpl, $data, $key),
                    CommonUtils::MODE_ECHO);

            //执行默认的渲染行为
            default:
                $tpl = C::f('tpl')->getTpl($key, $componentPath.'/template.html');
                $data = C::f('data')->getData($key, $componentPath.'/data.json');
                $data = json_decode($data, true);
                return CommonUtils::preReturn(
                    C::f('render')->render($tpl, $data, $key),
                    CommonUtils::MODE_ECHO);
        }
    }
}
