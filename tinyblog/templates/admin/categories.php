<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<div id="tips" style="display:none"></div>
	<? if($a == 'catelist') { ?>
	<div class="tb_left">
	<table align="left" class="tb_cate" cellspacing="0">
<form action=admin.php?m=categories&a=cateorder method=post>
  <tr class="title">
    <td><h3>分类名称</h3></td>
	<td><h3>自定义链接</h3></td>
    <td><h3>排序</h3></td>
	<td><h3>操作</h3></td>
<? foreach($catedb as $cate){
$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
?>
  <tr class="<?=$thisbg?>">
    <td><input type="hidden" name="cateid[]" value="<?=$cate['cateid']?>" /><?=$cate['catename']?></td>
	<td><?=$cate['cateurl']?></td>
    <td><input class="text" type="text" name="cateorder[]" value="<?=$cate['cateorder']?>" style="width:20px;padding:0px;text-align:center" /></td>
    <td width=100><a href=admin.php?m=categories&a=cateedit&cateid=<?=$cate['cateid']?>>编辑</a>  <a href=admin.php?m=categories&a=catedel&cateid=<?=$cate['cateid']?>>删除</a></td></tr>
<? } ?>	
<tr><td colspan="3"><input class="submit" type=submit value="修改排序" name=submit></td></tr>
</form>
</table>
	</div>
	<div class="tb_right">
<form name=form1 action=admin.php?m=categories&a=catesave method=post onSubmit="return checkCategoryForm()">
<ul>
<li><h3>分类名称</h3></li>
<li><input type="text" class="text" name="catename" style="width:178px" />
<li><h3>自定义链接</h3></li>
<li><input type="text" class="text" name="cateurl" style="width:178px" />
<li><h3>分类排序</h3></li>
<li><input type="text" class="text" name="cateorder" value="0" style="width:20px;text-align:center" /></li>
<li><input class="submit" type=submit value="增加分类" name=submit></li></ul>
</form>
	</div>
<? } ?>
<? if($a == 'cateedit') { ?>
<div class="tb_left">
<table class="tb_cate" cellspacing="0">
<form action=admin.php?m=categories&a=cateorder method=post>
  <tr class="title">
    <td><h3>分类名称</h3></td>
	<td><h3>自定义链接</h3></td>
    <td><h3>排序</h3></td>
	<td><h3>操作</h3></td>
<? foreach($catedb as $cate){
$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
?>
  <tr class="<?=$thisbg?>">
    <td><input type="hidden" name="cateid[]" value="<?=$cate['cateid']?>" /><?=$cate['catename']?></td>
	<td><?=$cate['cateurl']?></td>
    <td><input class="text" type="text" name="cateorder[]" value="<?=$cate['cateorder']?>" style="width:20px;padding:0px;text-align:center" /></td>
    <td width=100><a href=admin.php?m=categories&a=cateedit&cateid=<?=$cate['cateid']?>>编辑</a>  <a href=admin.php?m=categories&a=catedel&cateid=<?=$cate['cateid']?>>删除</a></td></tr>
<? } ?>	
<tr><td colspan="3"><input class="submit" type=submit value="修改排序" name=submit></td></tr>
</form>
</table>
</div>
<div class="tb_right">
<form name=form1 action=admin.php?m=categories&a=cateeditsave method=post onSubmit="return checkCategoryForm()">
<ul>
<li><h3>分类名称</h3></li>
<li><input type="text" class="text" name="catename"  value="<?=$category['catename']?>" style="width:178px" /><input type="hidden" name="cateid" value="<?=$category['cateid']?>">
<li><h3>自定义链接</h3></li>
<li><input type="text" class="text" name="cateurl" value="<?=$category['cateurl']?>" style="width:178px" />
<li><h3>分类排序</h3></li>
<li><input type="text" class="text" name="cateorder" value="<?=$category['cateorder']?>" style="width:20px;text-align:center" /></li>
<li><input class="submit" type=submit value="修改分类" name=submit></li></ul></td></tr>
</form>
</div>
<? } ?>
	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>