# 架构设计
## base
一些基础的工具类

## commands
命令类，目前只有一条主命令，控制整个逻辑流程，需要重构

## core
核心类，一些很轻量的架构设计

## event
事件模型实现

## interfaces
接口约定

# 本次重构接口上的变动
##C类外观的实现
C类做了大范围的调整，只要使用到了C类的静态方法都需要修正一下

比如之前使用

    C::cssStyleTag(array('src/global/a.css','src/global/b.csss'));
现在要改为

    C::f('html')->cssStyleTag(array('src/global/a.css','src/global/b.csss'));
模块指向说明，比如`C::f('html')`返回的是`HTMLTag`类的实例

    'e'         => 'EventDispatcher'
    'pm'        => 'PluginManager'
    '3f'        => 'ThirdParty'
    'data'      => 'DefaultData'(或者自定义的类)
    'tpl'       => 'DefaultTpl'(或者自定义的类)
    'filePack'  => 'FilePack'
    'render'    => 'PHPRender'(或者JSRender)

## DefaultData & DefaultTpl 的改动
第二个参数$path，需要传入完整路径。比如

原先使用

    $dd = new DefaultData();
    $dd->getData('a',ROOT.'/components/a');
现在需要更改为

    $dd = new DefaultData();
    $dd->getData('a',ROOT.'/components/a/data.json');


原先使用

    $dd = new DefaultTpl();
    $dd->getTpl('a',ROOT.'/components/a');
现在需要更改为

    $dd = new DefaultTpl();
    $dd->getTpl('a',ROOT.'/components/a/template.html');

## components方法的改进
之前由于组件内部规范的原因，导致Demo在数据上无法很好地做到仿真，现在提供不同的方式来

    <?php
    //默认的方式
    components('test');

    //选择不同的数据
    components('test', array(
        'data' => 'key',
        'tpl' => 'other'
    ));

    //直接使用PHP的对象
    components('test', array(
        'data' => array(
            'data' => 'From PHP Object'
        ),
        'tpl' => array('<div>{{data}} From PHP Object</div>')
    ));
    ?>


## 增加了mode=cdn模式
当`mode=cdn`时，js和css使用cdn的地址

（内部的assets的变量命名将不代表指向的是assets服务器的，也会是CDN的）

