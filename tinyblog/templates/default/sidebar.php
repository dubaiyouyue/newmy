	<div id="sidebar">
		<?php if($options['show_calendar']){ ?>
		<div class="widget">
			<h3>CALENDAR</h3>
			<table align="center" id="calendar" cellpadding="0" cellspacing="0" width="100%">
			<tr class="title">
			<td height="19" align="center"> 
			<a href="<?=$options['url']?>/index.php?reqdate=<?=$calendar['prem']?>">«</a>
			</td>
			<td colspan="5" align="center">
			<strong><?=$calendar['currentdate']?></strong>
			</td>
			<td align="center"> 
			<a href="<?=$options['url']?>/index.php?reqdate=<?=$calendar['nextm']?>">»</a>
			</td> 
			</tr>
			<tr>
			<td align="center" style="">Su</td> 
			<td align="center" style=""> Mo</td>
			<td align="center" style=""> Tu</td>
			<td align="center" style=""> We</td> 
			<td align="center" style=""> Th</td>
			<td align="center" style=""> Fr</td>
			<td align="center" style=""> Sa</td>
			</tr>
			<tr align="center">
			<?=$calendar['calendar']?>
			</tr>
			</table>
	    </div>
		<?php
		} 
		if($options['show_recentarticles']){
		?>
		<div class="widget">
			<h3>RECENT ARTICLES</h3>
            <ul>
			<? foreach($recentartcache as $recentart){?>
			<li><a href="<?=$recentart['pageurl']?>"><?=$recentart['title']?></a></li>
			<? } ?>
			</ul>
	    </div>
		<?php
		} 
		if($options['show_recentcomments']){
		?>
	    <div class="widget">
			<h3>RECENT COMMENTS</h3>
            <ul>
			<? foreach($recentcommentcache as $recentcomment){?>
			<li><a title="<?=$recentcomment['content']?>" href="<?=$recentcomment['pageurl']?>"><?=$recentcomment['username']?></a>:<?=$recentcomment['content']?></li>
			<? } ?>
			</ul>
	    </div>
		<?php
		} 
		if($options['show_categories']){
		?>
        <div class="widget">
			<h3>CATEGORIES</h3>
            <ul>
			<? foreach($categroriescache as $cate){ ?>
			<li>[<a title="rss" href="<?=$options['url']?>/rss.php?cateid=<?=$cate['cateid']?>">RSS</a>] <?=$cate['catename']?> [<a title="<?=$cate['catename']?>" href="<?=$cate['cateurl']?>"><?=$cate['artnum']?></a>]</li>
			<? } ?>
			</ul>
		</div>
		<?php
		} 
		if($options['show_archives']){
		?>
        <div class="widget">
			<h3>ARCHIVES</h3>
            <ul>
			<? if($options['ishtml']) { ?>
			<? foreach($archivecache as $archive){?>
			<li><a href="<?=$options['url']?>/times/<?=$archive['y']?>/<?=$archive['m']?>"><?=$archive['y']?>年<?=$archive['m']?>月</a> (<?=$archive['artnum']?>)</li>
			<? } ?>
			<? } else { ?>
			<? foreach($archivecache as $archive){?>
			<li><a href="<?=$options['url']?>/index.php?action=times&y=<?=$archive['y']?>&m=<?=$archive['m']?>"><?=$archive['y']?>年<?=$archive['m']?>月</a> (<?=$archive['artnum']?>)</li>
			<? } }?>
			</ul>
		</div>
		<?php } ?>
		<div class="widget">
			<h3>OTHERS</h3>
            <ul>
            <li class="last">
			<?php if($userid && $flag){ ?><a href="<?=$options['url']?>/?module=login&action=logout">退出</a>  <a href="<?=$options['url']?>/admin.php">进入后台</a> <?php }elseif($userid && $flag == 0){ ?> <a href="<?=$options['url']?>/?module=login&action=logout">退出</a> <a href="<?=$options['url']?>/index.php"><?=$username?></a><?php }else{ ?> <a href="<?=$options['url']?>/?module=register&action=register">注册</a> <a href="<?=$options['url']?>/?module=login&action=login">登陆</a><? } ?></li>
            <li><a href="http://validator.w3.org/check/referer">Valid XHTML</a></li>
            <li><a href="http://<?=$sys_config['official_site']?>"><?=$sys_config['soft_name']?> <?=$sys_config['version']?></a></li>
            </ul>
		</div>
		<?php
		if($options['show_links']){
		?>
		<div class="widget">
			<h3>LINKS</h3>
            <ul>
			<? foreach($recentlinkcache as $link){ ?>
			<li><a title="<?=$link['webname']?>" href="<?=$link['url']?>"><?=$link['webname']?></a></li>
			<? } ?>
			</ul>
		</div>
		<?php
		} 
		if($options['show_statistics']){
		?>
		<div class="widget">
			<h3>STATISTICS</h3>
            <ul>
			<li>分类：<?=$statisticscache['catenum']?></li>
			<li>文章：<?=$statisticscache['artnum']?></li>
			<li>评论：<?=$statisticscache['commentnum']?></li>
			<li>引用：<?=$statisticscache['tbnum']?></li>
			<li>标签：<?=$statisticscache['tagnum']?></li>
			<li>链接：<?=$statisticscache['linknum']?></li>
			<li>用户：<?=$statisticscache['usernum']?></li>
			<li>版本：V<?=$sys_config['version']?></li>
			<li>编码：utf-8</li>
			</ul>
		</div>
		<?php } ?>
	</div>