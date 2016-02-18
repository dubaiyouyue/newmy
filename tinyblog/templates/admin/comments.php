<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<? if ($a == 'commentlist') { ?>
	<table class="tb" cellspacing="0">
	<tr><td>&nbsp;</td><td><a href="admin.php?m=comments&a=commentlist&do=all"><strong>所有评论(<?=$all?>)</strong></a>&nbsp;&nbsp;<a href="admin.php?m=comments&a=commentlist&do=approved"><strong>已通过(<?=$approved?>)</strong></a>&nbsp;&nbsp;<a href="admin.php?m=comments&a=commentlist&do=waiting"><strong>待审核(<?=$wating?>)</strong></a></td>
  <td align="right"><form action="admin.php?m=comments&a=commentlist" method="post"><input class="text" type="text" name="keywords" /> <input class="submit" type="submit" value="筛选" /></form></td>
</tr></table>
<table class="tb" cellspacing="0">
<form name="form1" action="admin.php?m=comments&a=operator" method=post>
<input name="action" type="hidden" id="action" value="">
	<? foreach ($commentdb as $comment){
	$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
	?>
	<tr class="<?=$thisbg?>"><td valign="top"><div class="comment-checkbox"><input class="checkbox" type="checkbox" name="commentid[<?=$comment['commentid']?>]" value="1" /></div></td><td colspan="2" valign="top">
	<div class="comment">
	<div class="comment-author"><a href="<?=$comment['homepage']?>"><?=$comment['username']?></a> | <?=$comment['ipaddress']?></div>
	<div class="comment-content"><?=$comment['content']?></div>
	<div class="comment-info"><div class="comment-operate"><? if($comment['status'] == 'approved'){?>通过 | <a href="admin.php?m=comments&a=waiting&id=<?=$comment['commentid']?>">待审核</a><? } else { ?><a href="admin.php?m=comments&a=approved&id=<?=$comment['commentid']?>">通过</a> | 待审核<? } ?> | <a href="admin.php?m=comments&a=commentedit&id=<?=$comment['commentid']?>">编辑</a> | <a href="admin.php?m=comments&a=del&id=<?=$comment['commentid']?>">删除</a></div><div class="comment-data"><?=$comment['commenttime']?>&nbsp;&nbsp;<a href="<?=$comment['artpageurl']?>" target="_blank"><?=$comment['arttitle']?></a></div>
	<div class="fixed"></div>
	</div>
	</td></tr>
<? } ?>
<tr>
  <td colspan="5"><input class="checkbox" type="checkbox" name="chkall" value="全选" onClick="javascript:checkAll(this.form)" />
    全选 管理选项：<a href="#" onClick="{if(confirm('确定通过审核吗?')){document.form1.action.value='approved';this.document.form1.submit();return true;}return false;}">通过审核</a>		    <a  href="#" onClick="{if(confirm('设置为待审核吗?')){document.form1.action.value='wating';this.document.form1.submit();return true;}return false;}">待审核</a>
	<a href="#" onClick="{if(confirm('确定删除选定的评论吗?')){document.form1.action.value='delete';this.document.form1.submit();return true;}return false;}">删除选中</a>
	<a href="#" onClick="{if(confirm('确定删除数据表吗?')){document.form1.action.value='deleteall';this.document.form1.submit();return true;}return false;}">清空数据表</a></td>
  </tr>
<tr>  
</form>
</table>
<table class="tb2" cellspacing="0">
<tr><td><div id="pageview">
  <?=$page?>
</div></td></tr>
</table>
<? } ?>
<? if($a == 'commentedit') { ?>
<table class="tb" cellspacing="0">
<form action="admin.php?m=comments&a=commenteditsave" method="post">
<tr><td>
<div class="comment">
	<div class="comment-info"><input type="hidden" name="comment[id]" value="<?=$comment['id']?>" /><input class="text" type="text" name="comment[username]" style="width:162px;" value="<?=$comment['username']?>" /> <input class="text" type="text" name="comment[homepage]" style="width:322px;" value="<?=$comment['homepage']?>" /></div>
	<div class="comment-content">
	<textarea name="comment[content]" class="text" style="width:500px;height:200px;"><?=$comment['content']?></textarea>
	</div>
	<input type="submit" class="submit" value="保存评论" />
</div>
</td></tr>
</form>
</table>
<? } ?>
	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>