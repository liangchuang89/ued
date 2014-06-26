<?php
/**
 * 一些用到的正则测试
 * 创建于13-1-18，上午10:28
 * @author 宇山<yushan.yk@taobao.com>
 */
class RegExpTest extends PHPUnit_Framework_TestCase
{
    public function testGetLastDirName()
    {
        $preg = "/[^\/(\\\)]+$/";

        preg_match($preg,"/Users/yukan/Sites/tsrp",$tsrp);
        $this->assertEquals("tsrp",$tsrp[0]);

        preg_match($preg,"\\Users\\yukan\\Sites\\tsrp",$tsrp);
        $this->assertEquals("tsrp",$tsrp[0]);

        preg_match($preg,"/Users/yukan/Sites/tsrp/templates_inc",$inc);
        $this->assertEquals("templates_inc",$inc[0]);

        preg_match($preg,"\\Users\\yukan\\Sites\\templates_inc",$inc);
        $this->assertEquals("templates_inc",$inc[0]);
    }

    public function testHasSuffix()
    {
        //任意后缀
        $preg = "/\.[^\/]+$/";

        $this->assertTrue(preg_match($preg,"common/footer") == 0);
        $this->assertTrue(preg_match($preg,"common/footer.php") == 1);

        //css
        $preg = "/\.css+$/";

        $this->assertTrue(preg_match($preg,"common/footer") == 0);
        $this->assertTrue(preg_match($preg,"common/footer.css") == 1);

        //js
        $preg = "/\.js+$/";

        $this->assertTrue(preg_match($preg,"common/footer.json") == 0);
        $this->assertTrue(preg_match($preg,"common/footer.js") == 1);
    }


    /**
     * @dataProvider preg_path
     */
    public function testPackReg($preg, $path)
    {
        $this->assertTrue(preg_match($preg,$path) == 1);
    }

    public function preg_path(){
        return array(
            array("/^src\/[^_\/]+/","src/search"),
            array("/^src\/_[^\/]+_/","src/_libs_/sss"),
            array("/^components$/","components"),
            array("/^components\/_[^\/]+_/","components/_sss_"),
            array("/_[^\/]+_\/index/","tsrp/components/_component_/index.css"),
            array("/^imports$/","imports"),
            array("/^imports\/[^\/]+\/_[^\/]+_/","imports/ss.ss.ss/_ss_")
        );
    }

    public function testBreakPath()
    {
        preg_match("/[^\/]*html[^\/]*$/","sddd/ss/ssshtmlss",$match);
        $this->assertEquals("ssshtmlss",$match[0]);
        preg_match("/[^\/]*html[^\/]*$/","sddd/ss/html",$match);
        $this->assertEquals("html",$match[0]);

        preg_match("/[^\/]*json[^\/]*$/","sddd/ss/sssjsonss",$match);
        $this->assertEquals("sssjsonss",$match[0]);
        preg_match("/[^\/]*json[^\/]*$/","sddd/ss/json",$match);
        $this->assertEquals("json",$match[0]);
    }

    public function test_seek_js_for_class_name(){
        preg_match('/(\S+)\.METHOD/','  ClassName.METHOD ',$match);
        $this->assertEquals("ClassName.METHOD",$match[0]);
        $this->assertEquals("ClassName",$match[1]);
    }

    public function test_seek_js_for_method_name(){
        preg_match_all('/\{/','{ { { { } } }',$matcha);
        preg_match_all('/\}/','{ { { { } } }',$matchb);

        $this->assertEquals(1,count($matcha[0]) - count($matchb[0]));

        preg_match('/(\S+)\:function/','  ddd:function ',$match);
        $this->assertEquals("ddd:function",$match[0]);
        $this->assertEquals("ddd",$match[1]);

        preg_match('/(\S+)\:.*function/','  ddd: function ',$match);
        $this->assertEquals("ddd: function",$match[0]);
        $this->assertEquals("ddd",$match[1]);
    }


    public function testOther()
    {
        $preg = "/\s/";

        $this->assertEquals("ss_130111",preg_replace("/\s/",""," s s_ 1301 11"));


    }

}