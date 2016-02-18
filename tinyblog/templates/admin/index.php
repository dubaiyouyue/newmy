<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	  <div class="tb_index_left">
	  <h3><strong>最新发表的文章</strong></h3>
	   <ul>
	   <? if(!$articledb) { ?>
	   <li>您还没有<a href="admin.php?m=articles&a=artadd">发布文章</a>！</li>
			<? } else {
			foreach($articledb as $recentart){?>
			<li><a href="admin.php?m=articles&a=artedit&artid=<?=$recentart['artid']?>"><?=$recentart['title']?></a>&nbsp;&nbsp;发表于&nbsp;&nbsp;<a href="admin.php?m=categories&a=cateedit&cateid=<?=$recentart['cateid']?>"><?=$recentart['catename']?></a>&nbsp;&nbsp;<?=$recentart['updatetime']?></li>
			<? } }?>
			</ul>
	  </div>
	  <div class="tb_index_right">
	 <h3>网站信息</h3>
	  <ul>
	  <li>程序名称：<?=$sys_config['soft_name']?></li>
	  <li>官方地址：<a href="http://<?=$sys_config['official_site']?>">http://<?=$sys_config['official_site']?></a></li>
	  <li>程序设计：<?=$sys_config['author']?></li>
	  <li>程序版本：Version <?=$sys_config['version']?></li>
	  <li>操作系统及PHP：<?=$server['serverinfo']?></li>
	  <li>mysql版本：<?=$server['mysqlversion']?></li>
	  <li>上传许可：<?=$server['fileupload']?></li>
	  <li>当前数据库尺寸：<?=$server['dbsize']?></li>
	  <li>magic_quote_gpc：<?=$server['magic_quote_gpc']?></li>
	  </ul>
	  </div>
	  <div class="tb_index_bottom">
	  <h3>官方消息</h3>
	  <ul><li>暂无更新...</li></ul>
	  </div>
	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>