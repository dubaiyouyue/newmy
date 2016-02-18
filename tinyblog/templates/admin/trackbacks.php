<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<? if ($a == 'tblist'){ ?>
<table class="tb" cellspacing="0">
<form name=form1 action="admin.php?m=trackbacks&a=operator" method=post>
<input name="action" type="hidden" id="action" value="">
<? foreach($tbdb as $tb){
$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
?>
<tr class="<?=$thisbg?>"><td valign="top"><div class="comment-checkbox"><input class="checkbox" type="checkbox" name="tbid[<?=$tb['tbid']?>]" value="1" /></div></td><td colspan="2" valign="top">
	<div class="comment">
	<div class="comment-author"><a href="<?=$tb['url']?>" target="_blank"><?=$tb['title']?></a> | <?=$tb['ipaddress']?></div>
	<div class="comment-content"><?=$tb['excerpt']?></div>
	<div class="comment-info"><div class="comment-operate"><?=$tb['blogname']?></div><div class="comment-data"><?=$tb['updatetime']?>&nbsp;&nbsp;<a href="<?=$tb['artpageurl']?>"><?=$tb['arttitle']?></a></div>
	<div class="fixed"></div>
	</div>
	</td></tr>
<? } ?>
<tr>
  <td colspan="5"><input class="checkbox" type="checkbox" name="chkall" value="全选" onClick="javascript:checkAll(this.form)" />
    全选 管理选项：<a href="#" onClick="{if(confirm('确定删除选定的引用吗?')){document.form1.action.value='delete';this.document.form1.submit();return true;}return false;}">删除选中</a>
	<a href="#" onClick="{if(confirm('确定删除数据表吗?')){document.form1.action.value='deleteall';this.document.form1.submit();return true;}return false;}">清空数据表</a></td>
  </tr>
<tr></form>	  
</table>
<table class="tb2" cellspacing="0">
<tr><td><div id="pageview">
  <?=$page?>
</div></td></tr>
</table>
<? } ?>	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>