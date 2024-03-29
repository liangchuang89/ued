<?php
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-13 at 14:06:01.
 */
class FilePackTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var FilePack
     */
    protected $pack;

    protected function setUp()
    {
        $this->pack = new FilePack(array(
            "root"      => ROOT,
            "repoName"  => "tsrp",
        ));
    }

    /**
     * @dataProvider devpath
     * @covers FilePack::trans2dev
     */
    public function testTrans2Dev($path,$filetype,$expect)
    {
        $this->assertEquals($expect,$this->pack->trans2dev($path,$filetype));
    }

    /**
     * @dataProvider assetspath
     * @covers FilePack::trans2dev
     */
    public function testTrans2Assets($path,$version,$filetype,$expect)
    {
        $this->assertEquals($expect,$this->pack->trans2assets($path,$version,$filetype,'url/'));
    }

    public function devpath(){
        return array(
            ////css模拟数据////
            //src下不存在的
            array(
                "src/searchaaa","css",
                array()
            ),
            //src下被打包的
            array(
                "src/search","css",
                array("src/search/a.a.a.base.css","src/search/a.a.a.tmp.css")
            ),
            //src下被忽略打包的
            array(
                "src/_libs_/fixed.css","css",
                array("src/_libs_/fixed.css")
            ),
            array(
                "src/_libs_/fixed","css",
                array("src/_libs_/fixed.css")
            ),
            //components下被打包的
            array(
                "components","css",
                array(
                    "components/acomponent/index.css",
                    "components/component/index.css")
            ),
            //imports下被打包的
            array(
                "imports","css",
                array(
                    "imports/srepo.ux.etao/component/index.css",
                    "imports/test.ux.etao/component/index.css")
            ),
            //components下被忽略的
            array(
                "components/_component_","css",
                array("components/_component_/index.css")
            ),
            array(
                "components/_component_/index.css","css",
                array("components/_component_/index.css")
            ),
            //imports下被忽略的
            array(
                "imports/srepo.ux.etao/_component_","css",
                array("imports/srepo.ux.etao/_component_/index.css")
            ),
            array(
                "imports/srepo.ux.etao/_component_/index.css","css",
                array("imports/srepo.ux.etao/_component_/index.css")
            ),
            //多个的情况
            array(
                "src/search, src/_libs_/fixed, components,imports, components/_component_,imports/srepo.ux.etao/_component_","css",
                array(
                    "src/search/a.a.a.base.css",
                    "src/search/a.a.a.tmp.css",
                    "src/_libs_/fixed.css",
                    "components/acomponent/index.css",
                    "components/component/index.css",
                    "imports/srepo.ux.etao/component/index.css",
                    "imports/test.ux.etao/component/index.css",
                    "components/_component_/index.css",
                    "imports/srepo.ux.etao/_component_/index.css"
                )
            ),


            ////js模拟数据////
            //src下被打包的
            array(
                "src/search","js",
                array("src/search/a.base.js","src/search/a.form-validate.js")
            ),
            //src下被忽略打包的
            array(
                "src/_libs_/cutelink.js","js",
                array("src/_libs_/cutelink.js")
            ),
            array(
                "src/_libs_/cutelink","js",
                array("src/_libs_/cutelink.js")
            ),
            //components下被打包的
            array(
                "components","js",
                array(
                    "components/acomponent/index.js",
                    "components/component/index.js")
            ),
            //imports下被打包的
            array(
                "imports","js",
                array(
                    "imports/srepo.ux.etao/component/index.js",
                    "imports/test.ux.etao/component/index.js")
            ),
            //components下被忽略的
            array(
                "components/component","js",
                array("components/component/index.js")
            ),
            array(
                "components/component/index.js","js",
                array("components/component/index.js")
            ),
            //imports下被忽略的
            array(
                "imports/srepo.ux.etao/_component_","js",
                array("imports/srepo.ux.etao/_component_/index.js")
            ),
            array(
                "imports/srepo.ux.etao/_component_/index.js","js",
                array("imports/srepo.ux.etao/_component_/index.js")
            ),
            //多个的情况
            array(
                "src/search,src/_libs_/cutelink,components,imports,components/_component_, imports/srepo.ux.etao/_component_","js",
                array(
                    "src/search/a.base.js",
                    "src/search/a.form-validate.js",
                    "src/_libs_/cutelink.js",
                    "components/acomponent/index.js",
                    "components/component/index.js",
                    "imports/srepo.ux.etao/component/index.js",
                    "imports/test.ux.etao/component/index.js",
                    "components/_component_/index.js",
                    "imports/srepo.ux.etao/_component_/index.js"
                )
            ),
        );
    }

    public function assetspath(){
        return array(
            ////css模拟数据////
            //src下被打包的
            array(
                "src/search","130121","css",
                "url/tsrp/130121/search.css"
            ),
            //src下被忽略的
            array(
                "src/_libs_/fixed.css","130121","css",
                "url/tsrp/130121/_libs_/fixed.css"
            ),
            array(
                "src/_libs_/fixed","130121","css",
                "url/tsrp/130121/_libs_/fixed.css"
            ),
            //components下被打包的
            array(
                "components","130121","css",
                "url/tsrp/130121/components/components.css"
            ),
            //imports下被打包的
            array(
                "imports","130121","css",
                "url/tsrp/130121/imports/imports.css"
            ),
            //components下被忽略的
            array(
                "components/_component_","130121","css",
                "url/tsrp/130121/components/_component_/index.css"
            ),
            array(
                "components/_component_/index.css","130121","css",
                "url/tsrp/130121/components/_component_/index.css"
            ),
            //imports下被忽略的
            array(
                "imports/srepo.ux.etao/_component_","130121","css",
                "url/tsrp/130121/imports/srepo.ux.etao/_component_/index.css"
            ),
            array(
                "imports/srepo.ux.etao/_component_/index.css","130121","css",
                "url/tsrp/130121/imports/srepo.ux.etao/_component_/index.css"
            ),
            //多个的情况
            array(
                "src/search,src/_libs_/fixed,components,imports,components/_component_, imports/srepo.ux.etao/_component_","130121","css",
                "url/tsrp/??130121/search.css,130121/_libs_/fixed.css,130121/components/components.css,130121/imports/imports.css,130121/components/_component_/index.css,130121/imports/srepo.ux.etao/_component_/index.css"
            ),
            array(
                "src/search,src/_libs_/fixed,components,imports,components/_component_, imports/srepo.ux.etao/_component_","130121,130121,130121","css",
                "url/tsrp/??130121/search.css,130121/_libs_/fixed.css,130121/components/components.css,130121/imports/imports.css,130121/components/_component_/index.css,130121/imports/srepo.ux.etao/_component_/index.css"
            ),
            array(
                "src/search,src/_libs_/fixed,components,imports,components/_component_, imports/srepo.ux.etao/_component_","130121,130121,130121,130121,130121,130121,130121","css",
                "url/tsrp/??130121/search.css,130121/_libs_/fixed.css,130121/components/components.css,130121/imports/imports.css,130121/components/_component_/index.css,130121/imports/srepo.ux.etao/_component_/index.css"
            ),
            array(
                "src/search,src/_libs_/fixed,components,imports,components/_component_, imports/srepo.ux.etao/_component_","130121,130121,130121,130121,130121,130121","css",
                "url/tsrp/??130121/search.css,130121/_libs_/fixed.css,130121/components/components.css,130121/imports/imports.css,130121/components/_component_/index.css,130121/imports/srepo.ux.etao/_component_/index.css"
            ),

            ////js模拟数据////
            //src下被打包的
            array(
                "src/search","130121","js",
                "url/tsrp/130121/search.js"
            ),
            //src下被忽略的
            array(
                "src/_libs_/cutelink.js","130121","js",
                "url/tsrp/130121/_libs_/cutelink.js"
            ),
            array(
                "src/_libs_/cutelink","130121","js",
                "url/tsrp/130121/_libs_/cutelink.js"
            ),
            //components下被打包的
            array(
                "components","130121","js",
                "url/tsrp/130121/components/components.js"
            ),
            //imports下被打包的
            array(
                "imports","130121","js",
                "url/tsrp/130121/imports/imports.js"
            ),
            //components下被忽略的
            array(
                "components/_component_","130121","js",
                "url/tsrp/130121/components/_component_/index.js"
            ),
            array(
                "components/_component_/index.js","130121","js",
                "url/tsrp/130121/components/_component_/index.js"
            ),
            //imports下被忽略的
            array(
                "imports/srepo.ux.etao/_component_","130121","js",
                "url/tsrp/130121/imports/srepo.ux.etao/_component_/index.js"
            ),
            array(
                "imports/srepo.ux.etao/_component_/index.js","130121","js",
                "url/tsrp/130121/imports/srepo.ux.etao/_component_/index.js"
            ),
            //多个的情况
            array(
                "src/search,src/_libs_/cutelink,components,imports,components/_component_, imports/srepo.ux.etao/_component_","130121","js",
                "url/tsrp/??130121/search.js,130121/_libs_/cutelink.js,130121/components/components.js,130121/imports/imports.js,130121/components/_component_/index.js,130121/imports/srepo.ux.etao/_component_/index.js"
            ),
            array(
                "src/search,src/_libs_/cutelink,components,imports,components/_component_, imports/srepo.ux.etao/_component_","130121,130121,130121","js",
                "url/tsrp/??130121/search.js,130121/_libs_/cutelink.js,130121/components/components.js,130121/imports/imports.js,130121/components/_component_/index.js,130121/imports/srepo.ux.etao/_component_/index.js"
            ),
            array(
                "src/search,src/_libs_/cutelink,components,imports,components/_component_, imports/srepo.ux.etao/_component_","130121,130121,130121,130121,130121,130121,130121","js",
                "url/tsrp/??130121/search.js,130121/_libs_/cutelink.js,130121/components/components.js,130121/imports/imports.js,130121/components/_component_/index.js,130121/imports/srepo.ux.etao/_component_/index.js"
            ),
            array(
                "src/search,src/_libs_/cutelink,components,imports,components/_component_, imports/srepo.ux.etao/_component_","130121,130121,130121,130121,130121,130121","js",
                "url/tsrp/??130121/search.js,130121/_libs_/cutelink.js,130121/components/components.js,130121/imports/imports.js,130121/components/_component_/index.js,130121/imports/srepo.ux.etao/_component_/index.js"
            )
        );
    }


}
