<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<? if ($a == 'tagslist'){ ?>
<table class="tb" cellpadding="5" cellspacing="0">
<form name=form1 action="admin.php?m=tags&a=operator" method=post>
<input name="action" type="hidden" id="action" value="">
  <tr class="title">
    <td width="20">ID</td>
    <td width="500">文章标题</td>
    <td>标签</td>
</tr>
<? foreach($tagdb as $tag){
$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
?>
  <tr class="<?=$thisbg?>">
    <td><input class="checkbox" type="checkbox" name="tagid[<?=$tag['tagid']?>]" value="1" /><input type="hidden" name="artid[<?=$tag['artid']?>]" value="1" /></td>
    <td><a href="<?=$tag['artpageurl']?>" target="_blank"><?=$tag['arttitle']?></a></td>
    <td><?=$tag['tag']?></td>
</tr>
<? } ?>
<tr>
  <td colspan="3"><input class="checkbox" type="checkbox" name="chkall" value="全选" onClick="javascript:checkAll(this.form)" />
    全选 管理选项：<a href="#" onClick="{if(confirm('确定删除选定的标签吗?')){document.form1.action.value='delete';this.document.form1.submit();return true;}return false;}">删除选中</a>
	<a href="#" onClick="{if(confirm('确定删除数据表吗?')){document.form1.action.value='deleteall';this.document.form1.submit();return true;}return false;}">清空数据表</a></td>
  </tr>
<tr>
</form>
<table class="tb2" cellspacing="0">
<tr><td><div id="pageview">
  <?=$page?>
</div></td></tr>
</table>
<? } ?>
	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>