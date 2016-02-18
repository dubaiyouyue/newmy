<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<div id="tips" style="display:none"></div>
	<? if ($a == 'artadd'){?>
	   <form name="form1" action=admin.php?m=articles&a=artsave method=post onSubmit="return checkArticleForm()">
	   <div class="tb_left">
	  <ul>
	  <li><h3>日志标题</h3></li>
	    <li><input name="title" type="text" class="text" style="width:560px;" /></li>
		<li><h3>日志内容</h3></li>
		<li>
		<div class="editor">
		<script>
		var editor = editor('content');
		document.write (editor);
		</script>
		<div class="editor_text">
		    <textarea name='content' id='content'></textarea>
		 </div>
	    </div>
	 	<div class="fixed"></div>
		</li>
		<li style="text-align:right"><div style="float:left;font-size:12px;"><a class="button" style="color:#333" href="javascript:showMore('artadd');">更多选项 »</a></div>
		<input class="submit" type="submit" value=" 发布文章 "></li>
		</ul>
		<div class="fixed"></div>
		</div>
	  <div class="tb_right">
	  <ul>
	  	<li><h3>分类</h3></li>
	    <li><select name="cateid" style="width:160px;">
	      <?=$cateoption?>
        </select></li>
		<li><h3><input type="checkbox" name="istop" value="1">&nbsp;是否置顶</h3></li>
	    <li><h3>自定义链接</h3></li>
		<li><input type="text" class="text" name="htmlurl" style="width:150px;"></li>
		<li><h3>标签</h3></li>
	    <li><input size="60" class="text" name="tags" style="width:150px;"></li>
		<li><h3><input type="checkbox" name="ischangetime" value="1">&nbsp;更改发布时间</h3></li>
	      <li><input type="text" class="text" name="year" value="<?=$year?>" style="width:25px;text-align:center" />
	      年
          <input type="text" class="text" name="month" value="<?=$month?>" style="width:25px;text-align:center" />
	      月
          <input type="text" class="text" name="day" value="<?=$day?>" style="width:25px;text-align:center" />
	      日</li>
          <li><input type="text" class="text" name="hour" value="<?=$hour?>" style="width:25px;text-align:center" />
	      时
          <input type="text" class="text" name="minute" value="<?=$minute?>" style="width:25px;text-align:center" />
	      分
          <input type="text" class="text" name="second" value="<?=$second?>" style="width:25px;text-align:center" />
        秒</li> 
		</ul>
		<div class="fixed"></div>
		</div>
	<div class="tb_more" id="artadd" style="display:none">
	<ul>
	<li><h3>日志描述</h3></li>
	<li><textarea class="text" id="abstract"  name="abstract" style="width:560px;height:100px;"></textarea></li>
	<li><h3>日志引用</h3></li>
	<li><input type="text" class="text" name="trackback" style="width:560px;"></li>
	<div id="msgList">
		<?php foreach($attachment as $attach) {?>
		<dl id="attach_<?=$attach['id']?>"><dt><?=$attach['truefilename']?></dt><dd><a href="javascript:addAttachToEditor('<?=$attach['value']?>')">插入</a> , <a href="javascript:delAttach('<?=$attach['id']?>')">删除</a></dd><div class="fixed"></div></dl>
		<?php } ?>
	</div>
	<li><h3>附件上传</h3></li>
	<li><iframe frameborder=0 width=650 height=40 scrolling=no src="inc/upload.php?action=attach&artid=<?=$artid?>"></iframe></li>
	</ul>
	</div></form>
	<? } ?>
	<? if ($a == 'artedit'){?>
	   <form name="form1" action=admin.php?m=articles&a=arteditsave method=post onSubmit="return checkArticleForm()"><input type="hidden" name="artid" value="<?=$article['artid']?>" />
	   <div class="tb_left">
	  <ul>
	  <li><h3>日志标题</h3></li>
	    <li><input name="title" type="text" value="<?=$article['title']?>" class="text" style="width:560px;" /></li>
		<li><h3>日志内容</h3></li>
		<li>
		<div class="editor">
		<script>
		var editor = editor('content');
		document.write (editor);
		</script>
		<div class="editor_text">
		    <textarea name='content' id='content'><?=$article['content']?></textarea>
		 </div>
	    </div>
	 	<div class="fixed"></div>
		</li>
		<li style="text-align:right"><div style="float:left;font-size:12px;"><a class="button" style="color:#333" href="javascript:showMore('artadd');">更多选项 »</a></div>
		<input class="submit" type="submit" value=" 发布文章 "></li>
		</ul>
		<div class="fixed"></div>
		</div>
	  <div class="tb_right">
	  <ul>
	  	<li><h3>分类</h3></li>
	    <li><select name="cateid" style="width:160px;">
	      <?=$cateoption?>
        </select></li>
		<li><h3><input type="checkbox" name="istop" value="1" <? if ($article['istop'] == 1){ ?>checked<? } ?>> <input type=hidden name="artid" value="<?=$article['artid']?>">&nbsp;是否置顶</h3></li>
	    <li><h3>自定义链接</h3></li>
		<li><input type="text" class="text" name="htmlurl" value="<?=$article['htmlurl']?>" style="width:150px;"></li>
		<li><h3>标签</h3></li>
	    <li><input size="60" class="text" name="tags" value="<?=$article['tags']?>" style="width:150px;"></li>
		<li><h3><input type="checkbox" name="ischangetime" value="1">&nbsp;更改发布时间</h3></li>
	      <li><input type="text" class="text" name="year" value="<?=$year?>" style="width:25px;text-align:center" />
	      年
          <input type="text" class="text" name="month" value="<?=$month?>" style="width:25px;text-align:center" />
	      月
          <input type="text" class="text" name="day" value="<?=$day?>" style="width:25px;text-align:center" />
	      日</li>
          <li><input type="text" class="text" name="hour" value="<?=$hour?>" style="width:25px;text-align:center" />
	      时
          <input type="text" class="text" name="minute" value="<?=$minute?>" style="width:25px;text-align:center" />
	      分
          <input type="text" class="text" name="second" value="<?=$second?>" style="width:25px;text-align:center" />
        秒<input type="hidden" name="updatetime" value="<?=$article['updatetime']?>" /></li> 
		</ul>
		<div class="fixed"></div>
		</div>
	<div class="tb_more" id="artadd" style="display:none">
	<ul>
	<li><h3>日志描述</h3></li>
	<li><textarea class="text" id="abstract"  name="abstract" style="width:560px;height:100px;"><?=$article['abstract']?></textarea></li>
	<li><h3>日志引用</h3></li>
	<li><input type="text" class="text" name="trackback" style="width:560px;"></li>
	<div id="msgList">
		<?php foreach($attachment as $attach) {?>
		<dl id="attach_<?=$attach['id']?>"><dt><?=$attach['truefilename']?></dt><dd><a href="javascript:addAttachToEditor('<?=$attach['value']?>')">插入</a> , <a href="javascript:delAttach('<?=$attach['id']?>')">删除</a></dd><div class="fixed"></div></dl>
		<?php } ?>
	</div>
	<li><h3>附件上传</h3></li>
	<li><iframe frameborder=0 width=650 height=40 scrolling=no src="inc/upload.php?action=attach&artid=<?=$artid?>"></iframe></li>
	</ul>
	</div></form>
	<? } ?>
	<? if ($a == 'artlist'){?>
	<table class="tb" cellspacing="0"><form action="admin.php?m=articles&a=artlist&do=search" method="post"><tr><td><input type="text" name="keywords" style="padding:1px;" /> <select name="cateid"><option value="0">全部分类</option><?=$cateoption?></select> <input type="submit" class="submit" value="筛选" />&nbsp;&nbsp;<a href="admin.php?m=articles&a=artlist&type=istop"><strong>置顶文章</strong></a> </td></tr></form></table>
	<table class="tb" cellspacing="0">
	<form name=form1 action="admin.php?m=articles&a=operator" method=post><input name="action" type="hidden" id="action" value="">
	<tr class="title"><td>标题</td><td>作者</td><td>分类</td><td>评论/引用</td><td>属性</td><td>发布日期</td></tr>
	<? if(!$artdb) { ?>
	<tr><td colspan="6">您还没有发布文章！</td></tr>
	<? } else {
	 foreach($artdb as $art){
	$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
?>
	<tr class="<?=$thisbg?>"><td><input class="checkbox" type="checkbox" name="artid[<?=$art['artid']?>]" value="1" />&nbsp;<a href=admin.php?m=articles&a=artedit&artid=<?=$art['artid']?>><?=$art['title']?></a></td>
	<td><?=$art['username']?></td><td><?=$art['catename']?></td><td><?=$art['commentnum']?>/<?=$art['tbnum']?></td><td><?=$art['istop']?></td><td><?=$art['updatetime']?></td>
	</tr>
	<? } }?>
	<tr class="tb_bottom"><td colspan="6"><input class="checkbox" type="checkbox" name="chkall" value="全选" onClick="javascript:checkAll(this.form)" />&nbsp;全选 管理选项：<a href="#" onClick="{if(confirm('确定删除选定的文章吗?')){document.form1.action.value='delete';this.document.form1.submit();return true;}return false;}">删除选中</a>
	<a href="#" onClick="{if(confirm('确定删除数据表吗?')){document.form1.action.value='deleteall';this.document.form1.submit();return true;}return false;}">清空数据表</a>
<a href="#" onClick="{if(confirm('确定置顶选定的文章吗?')){document.form1.action.value='settop';this.document.form1.submit();return true;}return false;}">置顶</a>
<a href="#" onClick="{if(confirm('确定取消置顶的文章吗?')){document.form1.action.value='nosettop';this.document.form1.submit();return true;}return false;}">取消置顶</a>
<a href="#" onClick="{if(confirm('确定移动选定的文章吗?')){document.form1.action.value='move';this.document.form1.submit();return true;}return false;}">移动</a></td></tr></form>
</table>
<table class="tb2" cellspacing="0">
<tr><td><div id="pageview">
  <?=$page?>
</div></td></tr>
</table>
	<? } ?>
	<? if ($action == 'move'){
?>
<table class="tb" cellspacing="1">
<tr><td><form action="admin.php?m=articles&a=operator" method="post">
<input type="hidden" name="action" value="moveart" />
<input type="hidden" name="artidstr" value="<?=$artidstr?>" />
<select name=cateid>
<?=$cateoption?>
</select>
<input class="submit" type="submit" value="移动" />
</form>
</td></tr>
</table>
<? } ?>
	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>