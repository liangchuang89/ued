## Commonless

### Grid

40槽40列的栅格系统

* For Width： `.cols-@{index}`，宽度结果 percentage((@colWidth * @index) / @screenWidth)
* For Margin： `.ml-@{index}`，margin-left结果 percentage(@spaceWidth * @index / @screenWidth);

### Color

* **Block系列**：用于topbar、按钮、搜索框、标签、icon
	
	* @blockMainColor: 主色
	* @blockAccentColorLight： 主色辅助色（浅）
	* @blockAccentColorDark： 主色辅助色（深）

* **Text系列**

	* @textLinkColor： 文字连接
	* @textPriceColor：促销，价格优惠
	* @textFirstLevel：一级标签
	* @textSecondLevel：二级标签

* **背景色**：用于topbar、按钮、标签、icon

	* @bgcGray：灰色背景（#f1f1f1）
	* @bgcBlank：白色背景（#fff）

* **边框系列**

	* @bdcGray：灰色边框（#ccc）

### Function

* .boxSizing(@mod)：设置盒子模型

	```
	.boxSizing(border-box);
	```

* .setBtnSkin(@bdc, @bgc, @acbg, @color)：设置按钮皮肤

	```
	/* @bdc 边框颜色 */
	/* @bgc 背景颜色 */
	/* @acbg active状态背景颜色 */
	/* @color 文本颜色 */
	.setBtnSkin(@blockMainColor, @bgcBlank, rgba(0, 0, 0, 0.1), @blockMainColor);
	```

### Button

* `.btns`：默认样式
* `.btns .btn-promotion`：促销按钮
* `.btns .btn-strong`：强调按钮
* `.btns .btn-disabled`：失效按钮
* `.btn-through`：通栏按钮默认样式
* `.btn-through .btn-through-promotion`：通栏按钮促销样式
* `.btn-through .btn-through-disabled`：通栏按钮失效样式

### Radio

**注意**：单选功能使用radio实现，样式设置在label上，所以 **请注意DOM结构**。

* `.radios-group`：三列定宽单选

	```
	<div class="ml-2 radios-group">
        <input type="radio" name="radio" class="radios" id="radio-one">
        <label for="radio-one">标签文字</label>
    </div>
	```

* `.radios-group-middle`：四列定宽单选

	```
	<div class="ml-2 radios-group-middle">
        <input type="radio" name="radio" class="radios" id="radio-one">
        <label for="radio-one">标签文字</label>
    </div>
	```

* `.radios-group`：宽度不定单选

	```
	<div class="ml-2 radios-auto">
        <input type="radio" name="radio" class="radios" id="radio-one">
        <label for="radio-one">标签文字</label>
    </div>
	```

### Checkbox

**注意**：多选功能使用checkbox实现，样式设置在label上，所以 **请注意DOM结构**。

* `.checkboxs-group`：三列定宽多选

	```
	<div class="ml-2 checkboxs-group">
        <input type="checkbox" name="checkbox" class="checkboxs" id="checkboxs-one">
        <label for="checkboxs-one">标签文字</label>
    </div>
	```

* `.checkboxs-group-middle`：四列定宽多选

	```
	<div class="ml-2 checkboxs-group-middle">
        <input type="checkbox" name="checkbox" class="checkboxs" id="checkboxs-one">
        <label for="checkboxs-one">标签文字</label>
    </div>
	```

* `.checkboxs-group`：宽度不定多选

	```
	<div class="ml-2 checkboxs-auto">
        <input type="checkbox" name="checkbox" class="checkboxs" id="checkboxs-one">
        <label for="checkboxs-one">标签文字</label>
    </div>
	```