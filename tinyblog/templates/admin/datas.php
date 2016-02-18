<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<div id="tips" style="display:none"></div>
<table class="tb" cellspacing=0>
<tr class="title"><td width="30%">参数</td><td>类别</td><td>说明</td><td>操作</td></tr>
<tr class="content"><td>分类缓存(cache_categories)</td><td>文件缓存</td><td>更新分类缓存信息</td><td><a href="admin.php?m=datas&a=cache_categories">更新</a></td></tr>
<tr class="content2"><td>归档缓存(cache_archives)</td><td>文件缓存</td><td>更新archive缓存信息</td><td><a href="admin.php?m=datas&a=cache_archives">更新</a></td></tr>
<tr class="content"><td>最新文章(cache_recentart)</td><td>文件缓存</td><td>更新最新文章缓存信息</td><td><a href="admin.php?m=datas&a=cache_recentart">更新</a></td></tr>
<tr class="content2"><td>最新评论(cache_recentcomment)</td><td>文件缓存</td><td>更新最新评论缓存信息</td><td><a href="admin.php?m=datas&a=cache_recentcomment">更新</a></td></tr>
<tr class="content"><td>统计信息(cache_statistics)</td><td>文件缓存</td><td>更新统计信息缓存信息</td><td><a href="admin.php?m=datas&a=cache_statistics">更新</a></td></tr>
<tr class="content2"><td>日历信息(cache_calendar)</td><td>文件缓存</td><td>更新日历信息缓存信息</td><td><a href="admin.php?m=datas&a=cache_calendar">更新</a></td></tr>
<tr class="content"><td>最新链接(cache_recentlink)</td><td>文件缓存</td><td>更新最新链接缓存信息</td><td><a href="admin.php?m=datas&a=cache_recentlink">更新</a></td></tr>
<tr class="content2"><td>标签更新</td><td>数据库</td><td>更新每篇文章标签信息</td><td><a href="admin.php?m=datas&a=updatetags">更新</a></td></tr>
<tr class="content"><td>评论数更新</td><td>数据库</td><td>更新每篇文章评论数信息</td><td><a href="admin.php?m=datas&a=updatecommentnum">更新</a></td></tr>
<tr class="content2"><td>引用数更新</td><td>数据库</td><td>更新每篇文章引用数信息</td><td><a href="admin.php?m=datas&a=updatetbnum">更新</a></td></tr>
</table>
	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>