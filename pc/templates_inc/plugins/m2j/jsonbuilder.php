<!doctype html>
<html>
<head>
<meta charset="gbk">
<title>����json������</title>
<base target="_blank">
<link rel="search" type="application/opensearchdescription+xml" title="һ������" href="http://a.tbcdn.cn/apps/etao/provider.xml" />
<link rel="shortcut icon" href="http://www.etao.com/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="http://a.tbcdn.cn/apps/e/??brix/1.0/brix-min.css" />
</head>
<body>
<?php
function matchArr($arr) {
    $newArr;
    $circleArr = array();
    $circleStart = false;
    $listCount;
    $listName;
    foreach ($arr as $key => $value) {
        //echo $value;
        if($circleStart || preg_match('/\#(\w+)List(\d*)$/', $value, $matche)) {
            if($circleStart == false) {
                $listName = $matche[1];
                $listCount = $matche[2];
            } 
            $circleStart = true;
            if($value == '/' . $listName . 'List'.$listCount) {
                //echo "string";
                $circleStart = false;
                $newArr[$listName.'List'.$listCount] = circleTimes($listCount, $circleArr); 
            } elseif($value != '#'.$listName.'List'.$listCount) {
                array_push($circleArr, $value);
            }
        } else {
            $newArr[$value] = createVirtualData($value);
        }
    }
    return $newArr;
}

function circleTimes($times, $circleArr) {
    //var_dump($circleArr);
    $times = $times? $times:5;
    $allList=array();
    for ($i=0; $i<$times; $i ++) {
        array_push($allList, matchArr($circleArr));
    }
    return $allList;
}

/*�������*/
function createVirtualData($varName) {
    $result = '';
    if(preg_match("/^is[a-zA-Z\-_0-9]+/i",$varName)) {
        $result = ture;
    }

    if(preg_match("/^[a-zA-Z\-_0-9]+Link$/i",$varName)) {
        $result = 'http://www.etao.com';
    }

    if(preg_match("/^[a-zA-Z\-_0-9]+Txt$/i",$varName)) {
        //$result = iconv("GBK", "UTF-8", '�����ޱ�ů����ר�������Ż�ȯ�޽ڲٴ����');
        $result = urlencode('�����ޱ�ů����ר�������Ż�ȯ�޽ڲٴ����');
        //$result = 'adfasdlkfjsdfjdlsjfldsjf';
    }

    if(preg_match("/^[a-zA-Z\-_0-9]+Num$/i",$varName)) {
        $result = '12345';
    }

    if(preg_match("/^[a-zA-Z\-_0-9]+Price$/i",$varName)) {
        $result = '345.00';
    }

    if(preg_match("/^[a-zA-Z\-_0-9]+Img([0-9x]*)$/i",$varName, $matches)) {
        $result = 'http://img.f2e.taobao.net/img.png?x='. $matches[1];
    }
    return $result;
}

//��ʽ��json
function indent ($json) {
    $result = '';
    $pos = 0;
    $strLen = strlen($json);
    $indentStr = '  ';
    $newLine = "\n";
    $prevChar = '';
    $outOfQuotes = true;

    for ($i=0; $i<=$strLen; $i++) {

    // Grab the next character in the string.
    $char = substr($json, $i, 1);
    // Are we inside a quoted string?
    if ($char == '"' && $prevChar != '\\') {
        $outOfQuotes = !$outOfQuotes;
        // If this character is the end of an element,
        // output a new line and indent the next line.
    } else if(($char == '}' || $char == ']') && $outOfQuotes) {
        $result .= $newLine;
        $pos --;
        for ($j=0; $j<$pos; $j++) {
            $result .= $indentStr;
        }
    }
    // Add the character to the result string.
    $result .= $char;
    // If the last character was the beginning of an element,
    // output a new line and indent the next line.
    if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
        $result .= $newLine;
        if ($char == '{' || $char == '[') {
            $pos ++;
        }
        for ($j = 0; $j < $pos; $j++) {
            $result .= $indentStr;
        }
    }
    $prevChar = $char;
    }
    return $result;
}

///�����ļ�
function creat_file($PATH, $data) {
    $fp= fopen($PATH,"w+");
    fwrite($fp,$data);
    fclose($fp);
}

function createJSON($template) {
    $template = iconv("GBK", "UTF-8", $template);
    if(preg_match_all("{{([\w\/\#]*)}}", $template, $matches)) {
        //var arr = matchArr($matches[1]);
        return urldecode(iconv("UTF-8", "GBK", json_encode(matchArr($matches[1]))));
    }
}

$components = P::get('component');
if($components) {
    $path = ROOT."/components/$components";
    $template = str_replace(array("\n","\r"),'',file_get_contents($path."/template.html"));
    $data = createJSON($template);
    creat_file($path."/data.json", indent($data));
} else {
    $temp = $_POST['temp'];
    $jsonContainer=indent(createJSON($temp));
}
?>
<style>
    .tip ul li {color: orange;}
</style>

<?php if($components) { ?>
    <div style="padding: 50px; font-size:20px">data.json�Ѿ����ɣ��뵽<span style="border:1px solid #aaa;border-radius:5px;">components/<?php echo $components;?></span>Ŀ¼�²鿴</div>
    <?php } else { ?>
    <div style="padding: 10px 50px 50px;width:600px;margin:0 auto;">
        <div class="tip" style="background-color:snow;width: 600px;margin:0 auto 20px;padding:20px;border: 1px solid #CCC;border-radius: 5px;">
            <p>����mustacheģ���Զ���json������Լ����ģ����������������£�</p>
            <ul>
                <li>����: ��Link��β������http://www.etao.com</li>
                <li>ͼƬ����Img+ͼƬ��С��β��Ĭ�ϲ���ͼƬ��СΪ100x100���磺quanImg200��quanImg100x200</li>
                <li>�ı�����Txt��β,����20������</li>
                <li>���֣���Num��β,����12345</li>
                <li>�Ƿǣ���is��ͷ��Ĭ��Ϊtrue,�磺isLogin��isChecked</li>
                <li>ѭ������List+���ֽ�β��Ĭ�ϲ�������ѭ��5�飬�磺rankList10��rankList</li>
            </ul>
            <p>���磺</p>
            <pre>
&lt;div class="quan-hot"&gt;
    &lt;h3&gt;{{quanTitleTxt}}&lt;b class="quan-hot-title"&gt;&lt;/b&gt;&lt;/h3&gt;
    {{#quanList3}}
    &lt;div class="quan-img"&gt;
        &lt;a href="{{quanLink}}"&gt;&lt;img src="{{quanImg100x200}}" alt="{{quanTxt}}" /&gt;&lt;/a&gt;
    &lt;/div&gt;
    &lt;div class="quan-detail"&gt;&lt;h3>{{quanTxt}}&lt;/h3&gt;&lt;p class="info">����{{quanNum}}��&lt;/p&gt;&lt;/div&gt;
    {{/quanList3}}
&lt;/div&gt;
            </pre>
        </div>
        <form action="?m2j=1" method="post">
            <div><textarea placeholder="������mustacheģ��" style="padding:20px;border: 1px solid #CCC;height: 300px;dispaly:block;width:600px;margin:0 auto;border-radius: 5px;" name="temp" value="<?php echo $temp; ?>"></textarea></div>
            <div style="text-align:center;font-size: 20px;padding:10px;"><input type="submit" value="��json������"></div>
        </form>
        <div id="J_jsonContainer" style="background-color:snow;width: 600px;margin: 0 auto;padding:20px;border: 1px solid #CCC;border-radius: 5px;">
            <pre>
<?php echo $jsonContainer; ?>
            </pre>
        </div>
    </div>
<?php } ?>
</body>
</html>