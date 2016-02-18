<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<div id="tips" style="display:none"></div>
	<? if ($a == 'attach_db'){?>
  <table class="tb" cellspacing="0">
   <form name=form1 action="admin.php?m=attachment&a=operator" method=post><input name="action" type="hidden" id="action" value="">
	<tr class="title"><td width="30%">文件名</td>
	<td width="40%">文章</td><td width="10%">大小</td><td width="5%">类型</td><td width="15%">上传时间</td>
	</tr>
	<? foreach($attachdb as $attach){
	$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
?>
	<tr class="<?=$thisbg?>"><td><input class="checkbox" type="checkbox" name="attachid[<?=$attach['attachid']?>]" value="1" />&nbsp;<a href=<?=$attach['filename']?> target="_blank"><?=$attach['truefilename']?></a></td>
	<td><a href="admin.php?m=articles&a=artedit&artid=<?=$attach['artid']?>"><?=$attach['title']?></a></td><td><?=$attach['filesize']?></td><td><?=$attach['filetype']?></td><td><?=$attach['uploadtime']?></td>
	</tr>
	<? } ?>
	<tr class="content2">
  <td colspan="5"><input class="checkbox" type="checkbox" name="chkall" value="全选" onClick="javascript:checkAll(this.form)" />
    全选 管理选项：<a href="#" onClick="{if(confirm('确定删除选定的附件吗?')){document.form1.action.value='delete';this.document.form1.submit();return true;}return false;}">删除选中</a>
	<a href="#" onClick="{if(confirm('确定删除数据表吗?')){document.form1.action.value='deleteall';this.document.form1.submit();return true;}return false;}">清空数据表</a></td>
  </tr>
</form>
 </table>
 <table class="tb2" cellspacing="0">
<tr><td><div id="pageview">
  <?=$page?>
</div></td></tr>
<tr><td>您也可以使用<a href="admin.php?m=attachment&a=attach_file"><strong>文件式管理</strong></a></td></tr>
</table>
<? } ?>
<? if ($a == 'attach_file'){?>
  <table class="tb" cellspacing="0">
   <form name=form1 action="admin.php?m=attachment&a=operator2" method=post><input name="action" type="hidden" id="action" value=""> 
	<tr class="title"><td width="30%">文件名</td>
	<td>文件大小</td><td>文件类型</td><td>上传时间</td>
	</tr>
	<tr class="content2"><td colspan="5"><a href="admin.php?m=attachment&a=attach_file&dir=<?=$pre_dir?>">../</a></td></tr>
	<? foreach($dir_arr as $attach){
	$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
?>
	<tr class="<?=$thisbg?>"><td><input type="hidden" name="dir" value="<?=$dir?>" /><input class="checkbox" type="checkbox" name="attachname[<?=$dir.$attach['name']?>]" value="1" /><? if($attach['type'] == 'dir'){ ?><a href=admin.php?m=attachment&a=attach_file&dir=<?=$dir.$attach['name'].'/'?>><?=$attach['name']?></a><? } else { ?><?=$attach['name']?><? } ?></td>
	<td><?=$attach['size']?></td><td><?=$attach['type']?></td><td><?=$attach['time']?></td>
	</tr>
	<? } ?>
	<tr class="content2">
  <td colspan="5"><input class="checkbox" type="checkbox" name="chkall" value="全选" onClick="javascript:checkAll(this.form)" />
    全选 管理选项：<input class=button onClick="{if(confirm('确定删除选定的附件吗?')){document.form1.action.value='delete';this.document.form1.submit();return true;}return false;}" type=submit value="删除选中" /></td>
  </tr>
</form>
 </table>
<? } ?>
	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>