<?php

/**
 * 创建HTML标签
 * @author 宇山<yushan.yk@taobao.com>
 * @package base
 */
class HTMLTag
{

    /**
     * 创建js标签
     * @param $src
     * @param $addTimestamp
     * @return string
     */
    public function jsScriptTag($src, $addTimestamp = false){
        if($addTimestamp) $src .= '?t='.time();
        return "<script src=\"".$src."\"></script>\n";
    }

    /**
     * 创建css的link标签
     * @param $href
     * @param $addTimestamp
     * @return string
     */
    public function cssLinkTag($href, $addTimestamp = false){
        if($addTimestamp) $href .= '?t='.time();
        return "<link rel=\"stylesheet\" href=\"".$href."\"/>\n";
    }

    /**
     * 创建css的style标签
     * @param $hrefArr
     * @param $addTimestamp
     * @return string
     */
    public function cssStyleTag($hrefArr, $addTimestamp = false){
        $suffix = '';
        if($addTimestamp) $suffix = '?t='.time();

        $csstag = "<style>\n";
        //$r为重复的次数
        for($i = 0,$r = 1,$l = count($hrefArr);$i<$l;$i++){
            if($i > $r * 30){
                $r ++;
                $csstag .= "</style>\n<style>\n";
            }
            $csstag .= "@import \"".$hrefArr[$i].$suffix."\";\n";
        }
        $csstag .= "</style>\n";
        return $csstag;
    }

    /**
     * 创建注释的标签
     * @param $comment 注释内容
     * @return string
     */
    public function commentTag($comment){
        return '<!-- '.$comment.' -->';
    }

    /**
     * 创建script的标签
     * @param $script 脚本内容
     * @return string
     */
    public function scriptTag($script){
        return '<script>'.$script.'</script>';
    }

    public function imgTag($src){
        return '<img src="'.$src.'"/>';
    }
}
