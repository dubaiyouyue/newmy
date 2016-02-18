<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<div id="tips" style="display:none"></div>
	<table class="tb" cellspacing="0"><tr><td><a href="admin.php?m=database&a=tablelist"><strong>数据备份</strong></a>
<a href="admin.php?m=database&a=sqlfilelist"><strong>数据恢复</strong></a>
进行数据恢复操作后请进行<a href="admin.php?m=datas"><strong>数据重建</strong></a>操作</td></tr></table>
<? if($a == 'tablelist'){ ?>
<table class="tb" cellspacing="0">
<form name=form1 action="admin.php?m=database&a=export" method=post>
  <tr class="title">
  	<td><input class="checkbox" name='chkall' type='checkbox' id='chkall' onclick='javascript:checkAll(this.form)' value='check' checked>全选/反选</td>
    <td>表名</td>
	<td>记录数</td>
	<td>数据</td>
	<td>索引</td>
	<td>碎片</td>
</tr>
<? foreach($tdb as $table){ 
$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content'
?>
  <tr class="<?=$thisbg?>">
  	<td><input class="checkbox" type="checkbox" name="tables[]" value="<?=$table['Name']?>" checked></td>
    <td><?=$table['Name']?></td>
	<td><?=$table['Rows']?></td>
	<td><?=$table['Data_length']?></td>
	<td><?=$table['Index_length']?></td>
	<td><?=$table['Data_free']?></td>
</tr>
<? } ?>	 
<tr><td colspan="6">每个分卷文件大小<input class="text" type=text name="sizelimit" value="2048" style="width:30px; text-align:center"> K <input class="button" type="submit" name="dosubmit" value=" 开始备份数据 "></td></tr> 
</table>
</form>
<? } ?>
<? if($a == 'sqlfilelist'){ ?>
<table class="tb" cellspacing="0">
  <form name=form1 action="admin.php?m=database&a=delete" method=post>
  <tr class="title">
  	<td><input class="checkbox" name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check' checked>全选/反选</td>
    <td>id</td>
	<td>文件名</td>
	<td>文件大小</td>
	<td>备份时间</td>
	<td>卷号</td>
    <td>操作</td>
</tr>
<?
$id = 0;
foreach($infos as $info){ 
$id++;
?>
  <tr class="content3" bgcolor="<?=$info['bgcolor']?>">
  	<td><input class="checkbox" type="checkbox" name="filenames[]" value="<?=$info['filename']?>"></td>
    <td><?=$id?></td>
	<td><a href="admin/data/<?=$info['filename']?>"><?=$info['filename']?></a></td>
	<td><?=$info['filesize']?> M</td>
	<td><?=$info['maketime']?></td>
	<td><?=$info['number']?></td>
    <td><a href="admin.php?m=database&a=import&pre=<?=$info['pre']?>&dosubmit=1">导入</a> | 
	<a href="admin.php?m=database&a=delete&filenames=<?=$info['filename']?>">删除</a> | 
	<a href="admin.php?m=database&a=down&filename=<?=$info['filename']?>">下载</a>
	</td>
</tr>
<? } ?>	
<tr><td colspan="7">颜色相同的为同一次备份的文件</td></tr> 
<tr><td colspan="7"> <input class=button onClick="{if(confirm('确定删除选定?')){document.form1.action.value='delete';this.document.form1.submit();return true;}return false;}" type=submit value="删除选中的备份" /></td></tr> 
</table>
</form>
<? } ?>
	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>