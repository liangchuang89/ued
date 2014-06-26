<?php
/**
 * 创建于13-1-31，上午10:22
 * @author 宇山<yushan.yk@taobao.com>
 */
class CodeViewer
{
    private $basePath;

    function __construct()
    {

    }

    public function getComponentSourceCode($component,$viewsource){
        if(is_dir(ROOT."/components/".$component)) $cpnPath = ROOT."/components/".$component;
        else if(is_dir(ROOT."/imports/".$component)) $cpnPath = ROOT."/imports/".$component;
        else{
            echo '所选择的组件:'.$component.'不存在';
            exit;
        };
        //展示组件所有源码
        if(preg_match('/all/',$viewsource)) $viewsource = 'html/json/css/js';
        //匹配html,则输出组件模板源码
        if(preg_match('/html/',$viewsource))
            if(file_exists($cpnPath.'/template.html'))
                $this->pushCodeBlock($component.'组件的模板：',file_get_contents($cpnPath.'/template.html'),'xml');


        //匹配json,则输出组件数据源码
        if(preg_match('/json/',$viewsource))
            if(file_exists($cpnPath.'/data.json'))
                $this->pushCodeBlock($component.'组件的数据：',file_get_contents($cpnPath.'/data.json'),'js');

        //匹配css,则输出组件css源码
        if(preg_match('/css/',$viewsource))
            if(file_exists($cpnPath.'/index.css'))
                $this->pushCodeBlock($component.'组件的样式：',file_get_contents($cpnPath.'/index.css'),'css');

        //匹配js$,则输出组件js源码
        if(preg_match('/js$/',$viewsource))
            if(file_exists($cpnPath.'/index.js'))
                $this->pushCodeBlock($component.'组件的JS：',file_get_contents($cpnPath.'/index.js'),'js');

        $this->data['templates_inc'] = INC_NAME;
        return $this->data;
    }

    public function getPageSourceCode($filename,$viewsource){
        $pagepath = ROOT.'/templates/'.$filename;
        //默认展示index.php的源文件
        $file = 'index.php';
        //如果P::get('viewsource')指向的文件存在则输出该文件的源代码
        if(file_exists($pagepath.'/'.$viewsource.'.php')) $file = $viewsource.'.php';
        else if(file_exists($pagepath.'/'.$viewsource)) $file = $viewsource;
        $path = $pagepath.'/'.$file;
        $this->pushCodeBlock($filename.'页面下'.$file.'文件的源码：',file_get_contents($path),'xml');
        $this->data['templates_inc'] = INC_NAME;

        return $this->data;
    }


    private $data = array('codeblock'=>array());
    private function pushCodeBlock($description,$code,$language){
        $codeblock = array();
        $codeblock['description'] = $description;
        $codeblock['code'] = $code;
        $codeblock['language'] = $language;
        array_push($this->data['codeblock'],$codeblock);
    }


}
