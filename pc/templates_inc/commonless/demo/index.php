<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>ecc commonless demo</title>
    <link rel="stylesheet" href="../src/grid.css">
    <link rel="stylesheet" href="../src/button.css">
    <link rel="stylesheet" href="../src/tag.css">
</head>
<body>
<style>
    * { margin: 0; padding: 0; }
    a { text-decoration: none; }
    body { font-family: '\5fae\8f6f\96c5\9ed1', Arial;}
    .norm {
        /*padding-top: 15px;*/
    }
    .norm .mod-title {
        padding: 15px 10px;
    }
    .norm .btns, .norm .btn-through, .norm .radios-group, .norm .radios-group-middle, .norm .checkboxs-group, .norm .checkboxs-group-middle {
        margin-bottom: 10px;
    }
</style>
<div class="J_Norm norm">
    <h2 class="J_Title mod-title">Button</h2>
    <div class="J_Button button">
        <a href="#" class="ml-2 btns">默认样式</a><a href="#" class="ml-2 btns btn-promotion">商品促销
        </a><a href="#" class="ml-2 btns btn-strong">按钮加强</a><a href="#" class="ml-2 btns btn-disabled">无效按钮
        </a><a href="#" class="ml-2 btns btn-disabled-strong">无效按钮</a>
    </div>
    <div class="J_Button button">
        <a href="#" class="btn-through">通栏默认样式</a>
        <a href="#" class="btn-through btn-through-promotion">通栏促销样式</a>
        <a href="#" class="btn-through btn-through-disabled">通栏失效样式</a>
    </div>
    <h2 class="J_Title mod-title">Radio</h2>
    <div class="J_Radio radio">
        <div class="ml-2 radios-group">
            <input type="radio" name="radio" class="radios" id="radio-one">
            <label for="radio-one">标签文字</label>
        </div><div class="ml-2 radios-group">
            <input type="radio" name="radio" class="radios" id="radio-two">
            <label for="radio-two">标签文字</label>
        </div><div class="ml-2 radios-group">
            <input type="radio" name="radio" class="radios" id="radio-thr" disabled>
            <label for="radio-thr">标签文字</label>
        </div>
        <div class="ml-2 radios-group-middle">
            <input type="radio" name="radio-middle" class="radios" id="radio-fou">
            <label for="radio-fou">标签文字</label>
        </div><div class="ml-2 radios-group-middle">
            <input type="radio" name="radio-middle" class="radios" id="radio-fiv" disabled>
            <label for="radio-fiv">标签文字</label>
        </div><div class="ml-2 radios-group-middle">
            <input type="radio" name="radio-middle" class="radios" id="radio-six">
            <label for="radio-six">标签文字</label>
        </div><div class="ml-2 radios-group-middle">
            <input type="radio" name="radio-middle" class="radios" id="radio-sev">
            <label for="radio-sev">标签文字</label>
        </div>
        <div class="ml-2 radios-auto">
            <input type="radio" name="radio" class="radios" id="radio-eig">
            <label for="radio-eig">标签文字签文字</label>
        </div><div class="ml-2 radios-auto">
            <input type="radio" name="radio" class="radios" id="radio-nig">
            <label for="radio-nig">标签文字字</label>
        </div><div class="ml-2 radios-auto">
            <input type="radio" name="radio" class="radios" id="radio-ten" disabled>
            <label for="radio-ten">标签文</label>
        </div>
    </div>
    <h2 class="J_Title mod-title">Checkbox</h2>
    <div class="J_Radio checkbox">
        <div class="ml-2 checkboxs-group">
            <input type="checkbox" name="checkbox" class="checkboxs" id="checkbox-one">
            <label for="checkbox-one">标签文字<i class="flag"></i></label>
        </div><div class="ml-2 checkboxs-group">
            <input type="checkbox" name="checkbox" class="checkboxs" id="checkbox-two">
            <label for="checkbox-two">标签文字<i class="flag"></i></label>
        </div><div class="ml-2 checkboxs-group">
            <input type="checkbox" name="checkbox" class="checkboxs" id="checkbox-thr" disabled>
            <label for="checkbox-thr">标签文字<i class="flag"></i></label>
        </div>
        <div class="ml-2 checkboxs-group-middle">
            <input type="checkbox" name="checkbox-middle" class="checkboxs" id="checkbox-fou">
            <label for="checkbox-fou">标签文字<i class="flag"></i></label>
        </div><div class="ml-2 checkboxs-group-middle">
            <input type="checkbox" name="checkbox-middle" class="checkboxs" id="checkbox-fiv" disabled>
            <label for="checkbox-fiv">标签文字<i class="flag"></i></label>
        </div><div class="ml-2 checkboxs-group-middle">
            <input type="checkbox" name="checkbox-middle" class="checkboxs" id="checkbox-six">
            <label for="checkbox-six">标签文字<i class="flag"></i></label>
        </div><div class="ml-2 checkboxs-group-middle">
            <input type="checkbox" name="checkbox-middle" class="checkboxs" id="checkbox-sev">
            <label for="checkbox-sev">标签文字<i class="flag"></i></label>
        </div>
        <div class="ml-2 checkboxs-auto">
            <input type="checkbox" name="checkbox" class="checkboxs" id="checkbox-eig">
            <label for="checkbox-eig">标签文字签文字<i class="flag"></i></label>
        </div><div class="ml-2 checkboxs-auto">
            <input type="checkbox" name="checkbox" class="checkboxs" id="checkbox-nig">
            <label for="checkbox-nig">标签文字字<i class="flag"></i></label>
        </div>
    </div>
</div>
</body>
</html>