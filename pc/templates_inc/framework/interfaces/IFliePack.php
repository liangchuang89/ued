<?php
/**
 * 以FilePack类为列，详见FilePackTest中的测试用例
 * <h3>src目录下打包的文件夹</h3>
 * <pre>
 * trans2dev("src/search","css")
 * == ["src/search/a.a.a.base.css", "src/search/a.a.a.tmp.css",……]
 * </pre>
 * <pre>
 * trans2assets("src/search","css")
 * == "http://assets.etao.net/apps/e/tsrp/130121/search.css"
 * </pre>
 * <h3>src目录下被忽略的文件夹</h3>
 * <pre>
 * trans2dev("src/_libs_/cutelink.js","js")
 * == [ "src/_libs_/cutelink.js"]
 * </pre>
 * <pre>
 * trans2assets("src/_libs_/cutelink.js","js")
 * == "http://assets.etao.net/apps/e/tsrp/130121/_libs_/cutelink.js"
 * </pre>
 * <h3>imports或者componets目录</h3>
 * <pre>
 * trans2dev("components","js")
 * == [ "components/acomponent/index.js", "components/component/index.js",……]
 * trans2dev("imports","css")
 * == [ "imports/srepo.ux.etao/component/index.css", "imports/test.ux.etao/component/index.css",……]
 * </pre>
 * <pre>
 * trans2assets("imports","css")
 * == "http://assets.etao.net/apps/e/tsrp/130121/imports/imports.css"
 * trans2assets("components","js")
 * == "http://assets.etao.net/apps/e/tsrp/130121/components/components.js"
 * </pre>
 * <h3>imports或者componets目录被忽略的组件</h3>
 * <pre>
 * trans2dev("components/_component_","css")
 * == [ "components/_component_/index.css"]
 * trans2dev("imports/srepo.ux.etao/_component_","js")
 * == [ "imports/srepo.ux.etao/_component_/index.js"]
 * </pre>
 * <pre>
 * trans2assets("components/_component_","css")
 * == "http://assets.etao.net/apps/e/tsrp/130121/components/_component_/index.css"
 * trans2assets("imports/srepo.ux.etao/_component_","css")
 * == "http://assets.etao.net/apps/e/tsrp/130121/imports/srepo.ux.etao/_component_/index.css"
 * </pre>
 * <h3>多个一起</h3>
 * <pre>
 * trans2dev("src/search,src/_libs_/cutelink,components,imports,components/_component_,imports/srepo.ux.etao/_component_","js")
 * == [ "src/search/a.base.js",
 * "src/search/a.form-validate.js",
 * "src/_libs_/cutelink.js",
 * "components/acomponent/index.js",
 * "components/component/index.js",
 * "imports/srepo.ux.etao/component/index.js",
 * "imports/test.ux.etao/component/index.js",
 * "components/_component_/index.js",
 * "imports/srepo.ux.etao/_component_/index.js"]
 * </pre>
 * <pre>
 * trans2assets("src/search,src/_libs_/cutelink,components,imports,components/_component_,imports/srepo.ux.etao/_component_","js")
 * == "http://assets.etao.net/apps/e/tsrp/??130121/search.js,130121/_libs_/cutelink.js,130121/components/components.js,130121/imports/imports.js,130121/components/_component_/index.js,130121/imports/srepo.ux.etao/_component_/index.js"
 * </pre>
 * <br>创建于13-1-21，上午10:02
 * @author 宇山<yushan.yk@taobao.com>
 * @package interfaces
 */
interface IFliePack
{
    /**
     * 将输入路径转换为本地路径
     * @param $path
     * @param $filetype
     * @return array
     */
    public function trans2dev($path,$filetype);

    /**
     * 将输入的路径转换为assets路径
     * @param $path
     * @param $version
     * @param $filetype
     * @param $url
     * @return string
     */
    public function trans2assets($path,$version,$filetype,$url);
}
