<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<div id="tips" style="display:none"></div>
	<table class="tb" cellspacing="0"><tr><td><a href="admin.php?m=links&a=linkadd"><strong>添加链接</strong></a>
<a href="admin.php?m=links&a=linklist"><strong>管理链接</strong></a></td></tr></table>
	<? if ($a == 'linklist'){
?>
<table class="tb" cellpadding="5" cellspacing="0">
<form action=admin.php?m=links&a=linkorder method=post>
  <tr class="title">
    <td><h3>ID</h3></td>
    <td><h3>链接名称</h3></td>
	<td><h3>链接网址</h3></td>
    <td><h3>排序</h3></td>
	<td><h3>操作</h3></td>
<? foreach($linkdb as $link){
$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
?>
  <tr class="<?=$thisbg?>">
    <td width=35><?=$link['linkid']?><input type="hidden" name="linkid[]" value="<?=$link['linkid']?>" /></td>
    <td><?=$link['webname']?></td>
	<td><?=$link['url']?></td>
    <td><input class="text" type="text" name="linkorder[]" value="<?=$link['linkorder']?>" style="width:20px" /></td>
    <td width=100><a href=admin.php?m=links&a=linkedit&linkid=<?=$link['linkid']?>>编辑</a>  <a href=admin.php?m=links&a=linkdel&linkid=<?=$link['linkid']?>>删除</a></td></tr>
<? } ?>	
<tr><td colspan="5"><input type="submit" class="submit" value="修改排序" /></td></tr>
<tr><td colspan="5"><div id="pageview">
<ul><?=$page?></ul>
</div></td></tr>
</form>
</table>  
<? } ?>
<? if ($a == 'linkadd'){ ?>
<table class="tb" cellpadding="5" cellspacing="0">
<form action=admin.php?m=links&a=linksave method=post>
<tr><td>
<ul><li>
<h3>链接名称</h3>
</li><li>
<input type="text" class="text" name="webname" style="width:300px" />
</li><li>
<h3>链接地址</h3>
</li><li>
<input type="text" class="text" name="url" style="width:300px" />
</li><li>
<h3>分类排序</h3>
</li><li>
<input type="text" class="text" name="linkorder" value="0" style="width:20px" />
</li><li><input class="submit" type=submit value=" 提 交 " name=submit></li></ul></td></tr>
</form>
</table>
<? } ?>
<? if ($a == 'linkedit'){ ?>
<table class="tb" cellpadding="5" cellspacing="0">
<form action=admin.php?m=links&a=linkeditsave method=post>
<tr><td><ul><li>
<h3>链接名称</h3>
</li><li>
<input class=text value="<?=$link['webname']?>" name="webname" style="width:300px"><input type="hidden" name="linkid" value="<?=$link['linkid']?>">
</li><li>
<h3>链接地址</h3>
</li><li>
<input class=text value="<?=$link['url']?>" name="url" style="width:300px">
</li><li>
<h3>分类排序</h3>
</li><li>
<input type="text" class="text" name="linkorder" value="<?=$link['linkorder']?>" style="width:20px" />
</li>
<li><input class="submit" type=submit value=" 提 交 " name=submit></li></ul></td></tr>
</form>
</table>
<? } ?>	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>