<?php
/**
 * 提供一种数据注入的方式，以baobei-w页面为例：
 * 系统会在搜索templates下的baobei-w时，搜索相同目录下是否存在data.php，并判断其中是否包含一个实现了IData接口的类，类名必须为<code>页面名+data</code>,无<code>-</code><br/>
 * 比如:
 * <pre>
 * &lt;?php
 * class baobeiwdata implements IData
 * {
 *   function getData($key,$path)
 *   {
 *       switch($key){
 *           case 'personal-custom':
 *               $data = iconv('GBK','UTF-8','{"customed":"custom-btn-customed"}');
 *               break;
 *           default:
 *               $data = null;
 *       }
 *       return $data;
 *   }
 * }
 * ?&gt;
 * </pre>
 * 这样就会将<code>personal-custom</code>组件的原来的<code>{"customed":""}</code>和<code>{"customed":"custom-btn-customed"}</code>混合，类似<code>KISSY.merge()</code>。
 * @author 宇山<yushan.yk@taobao.com>
 * @package interfaces
 */
interface IData
{

    /**
     * 获取数据的方式
     * @abstract
     * @param $key 组件映射入口
     * @param $path 组件绝对路径
     * @return string
     */
    public function getData($key,$path);
}
