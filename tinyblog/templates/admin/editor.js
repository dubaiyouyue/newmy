//标签插入
function insert_tag(topen, tclose, id) {
	var themess = document.getElementById(id);//编辑对象:修改textarea:ID
    themess.focus();
    if (document.selection) {//如果是否ie浏览器
       var theSelection = document.selection.createRange().text;//获取选区文字
       //alert(theSelection);
       if(theSelection) {
    		document.selection.createRange().text = theSelection = topen+theSelection+tclose;//替换
       } else {
    		document.selection.createRange().text = topen+tclose;
       }
       theSelection='';
    
    } else {//其他浏览器
    
       var scrollPos = themess.scrollTop;
       var selLength = themess.textLength;
       var selStart = themess.selectionStart;//选区起始点索引，未选择为0
       var selEnd = themess.selectionEnd;//选区终点点索引
       if (selEnd <= 2)
       selEnd = selLength;
    
       var s1 = (themess.value).substring(0,selStart);//截取起始点前部分字符
       var s2 = (themess.value).substring(selStart, selEnd)//截取选择部分字符
       var s3 = (themess.value).substring(selEnd, selLength);//截取终点后部分字符
    
       themess.value = s1 + topen + s2 + tclose + s3;//替换
    
       themess.focus();
       themess.selectionStart = newStart;
       themess.selectionEnd = newStart;
       themess.scrollTop = scrollPos;
       return;
    }
}
//编辑器样式
function editor(textarea) {
    var id = textarea;
    str = ''
        +'<div class="editor_tool">'
            //加粗
            +'<a href="javascript:insert_tag('+"'[B]',"+"'[/B]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_b" title="字体加粗">加粗</a>'  
            //倾斜
            +'<a href="javascript:insert_tag('+"'[I]',"+"'[/I]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_i" title="字体倾斜">倾斜</a>'
            //下划线
            +'<a href="javascript:insert_tag('+"'[U]',"+"'[/U]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_u" title="添加下划线">下划线</a>'
            //字体大小
            +'<a href="javascript:insert_tag('+"'[SIZE=12px]',"+"'[/SIZE]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_size" title="字体大小">大小</a>' 
            //字体
            +'<a href="javascript:insert_tag('+"'[FONT=宋体]',"+"'[/FONT]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_font" title="字体">字体</a>'
            //引用
            +'<a href="javascript:insert_tag('+"'[QUOTE]',"+"'[/QUOTE]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_quote" title="引用">引用</a>' 
            //简单链接
            +'<a href="javascript:insert_tag('+"'[URL]http://url',"+"'[/URL]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_link" title="简单链接">简单链接</a>'
            //完整链接
            +'<a href="javascript:insert_tag('+"'[URL=http://url]linkName',"+"'[/URL]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_link" title="完整链接">完整链接</a>'  
            //红色
            +'<a href="javascript:insert_tag('+"'[RED]',"+"'[/RED]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_red" title="红色">红色</a>'  
            //绿色
            +'<a href="javascript:insert_tag('+"'[GREEN]',"+"'[/GREEN]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_green" title="绿色">绿色</a>'  
            //蓝色
            +'<a href="javascript:insert_tag('+"'[BLUE]',"+"'[/BLUE]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_blue" title="蓝色">蓝色</a>'   
            //颜色
            +'<a href="javascript:insert_tag('+"'[COLOR=#00000]',"+"'[/COLOR]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_color" title="自定义颜色">颜色</a>'   
            //居中
            +'<a href="javascript:insert_tag('+"'[CENTER]',"+"'[/CENTER]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_center" title="内容居中">居中</a>'  
            //居右
            +'<a href="javascript:insert_tag('+"'[RIGHT]',"+"'[/RIGHT]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_right" title="内容居右">居右</a>'   
            //插入图片
            +'<a href="javascript:insert_tag('+"'[IMG]url',"+"'[/IMG]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_img" title="插入图片">图片</a>'
            //插入Flash
            +'<a href="javascript:insert_tag('+"'[FLASH=400,300]url',"+"'[/FLASH]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_flash" title="插入Flash">Flash</a>' 
            //插入标签
            +'<a href="javascript:insert_tag('+"'[ATTACH=attachUrl]attachName',"+"'[/ATTACH]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_tag" title="插入附件">附件</a>' 
        +'</div>';
    return str;
}