<?php
	require 'header.php';
?>
<script type="text/javascript" src="<?=$options['url']?>/javascript/ajax.js"></script>
<script type="text/javascript" src="<?=$options['url']?>/javascript/post.js"></script>
<script>
function checkcomment(){
	var username=document.form1.username.value;
	var number=document.form1.number.value;
	var content=document.form1.content.value;
	if (username == ""){
		alert("名字不能为空！");
		document.form1.username.focus();
		return false;
	}
	if (number == ""){
		alert("验证码不能为空！");
		document.form1.number.focus();
		return false;
	}
	if (content == ""){
		alert("内容不能为空！");
		document.form1.content.focus();
		return false;
	}
	return true;
}
</script>
<div id="layout">
	<div id="main">
		<div class="post">
			<h2 class="post-title"><a href="<?=$article['pageurl']?>"><?=$article['title']?></a></h2>
			<p class="post-data">
				<span>作者：<?=$article['username']?></span>
				<span>发布时间：<?=$article['updatetime']?></span>
				<span>分类：<a href="<?=$article['cateurl']?>"><?=$article['catename']?></a></span> 
<?php if($article['commentnum']) {?> <a href="<?=$article['pageurl']?>"><?=$article['commentnum']?> Comments</a><? } else {?> <a href="<?=$article['pageurl']?>">No Comments</a><? } ?>
			</p>
			<div class="post-content">
			<?=$article['content']?>
			</div>
			<div class="post-tag">
			标签:<? if($article['tags']){?> <? foreach($article['tags'] as $tag){?><a title="<?=$tag['tagname']?>" href="<?=$tag['tagurl']?>"><?=$tag['tagname']?></a>&nbsp;<? } } else {?> None <? } ?>
			</div>  
		</div>
		<? if($options['istb']){?>
		<div class="post-trackback">引用地址：<?=$options['url']?>/trackback.php?tbid=<?=$article['artid']?>&tbkey=<script src="<?=$options['url']?>/javascript.php?a=showtbkey&artid=<?=$article['artid']?>" language="javascript"></script> (有效期很短哦！)</div>
		<? } ?>
		<? if($options['show_pre_next']){?>
		<div class="post-nav">
		<? if ($article['lastartrow']){?>
		<a class=l href="<?=$article['lastpageurl']?>">« <?=$article['lasttitle']?> </a>
		<? } ?>
		<? if ($article['nextartrow']){?>
		<a class=r href="<?=$article['nextpageurl']?>">» <?=$article['nexttitle']?> </a>
		<? } ?>
		<div class="fixed"></div>
		</div>
		<? } ?>
		<? if($options['show_relate']){?>
		<div class="relate">
			<h3>相关日志</h3>
			<ul>
			<? if(empty($relate_artdb)){?>
			<li>暂时没有相关日志！</li>
			<? }else{ ?>
			<? foreach($relate_artdb as $relate_art){ ?>
			<li><a href="<?=$relate_art['pageurl']?>"><?=$relate_art['title']?></a>&nbsp;(<?=$relate_art['commentnum']?>)</li>
			<? } }?>
			</ul>
		</div>
		<? } ?>
		<div class="comments">
			<? if(!$total){ ?>
			<h3>暂无评论 &raquo;</h3>
			<? } else {?>
            <h3>已有 <?=$total?> 条评论 &raquo;</h3>
			<? $i = 0;
			foreach($commentdb as $comment){
			$i++;
			?>
			<div class="comment" id="comment-<?=$comment['id']?>">
				<div class="comment-info"><a href="<?=$comment['homepage']?>"><?=$comment['username']?></a>&nbsp;<?=$comment['commenttime']?></div>
				<div class="comment-content" id="comm_<?=$i?>">
				<?=$comment['content']?>
				</div>
				<div class="comment-reply">
					<a href="#respond" onclick="addquote('comm_<?=$i?>','<?=$comment['username']?>')" alt="引用此文发表评论">#<?=$i?></a>
				</div>
			</div>
			<? } ?>
			<? if($page != '') {?>
			<div class="page">
				<?=$page?>
				<div class="fixed"></div>
			</div>
			<? } } ?>
			<div class="fixed"></div>
		</div>
		<? if(!$options['close_comment']){?>
		<? if($options['close_guestcomment'] && !$username){ ?>
		<div class="close_comment">游客不具有评论功能！ <a href="<?=$options['url']?>/?module=register">注册</a></div>
		<? } else { ?>
		<div class="comment-post">
			<h3>发表评论</h3>
			<form name="form1" action="<?=$article['commentsubmiturl']?>" method=post onSubmit="return checkcomment()">
			<div class="row"><input type="text" name="username" style="width:400px;" class="text" value="<?=$username?>" /><input type="hidden" value="<?=$article['artid']?>" name="artid" /><input type="hidden" value="<?=$article['pageurl']?>" name="pageurl" /> name*
			</div>
			<div class="row">
			<input type="text" name="homepage" style="width:400px;" value="<?=$homepage?>" class="text" /> homepage*
			</div>
			<? if($options['commentseccode']){?>
			<div class="row">
			<input type="text" name="number" style="width:400px;" class="text" />
			<img id="seccode" class="codeimg" src="<?=$options['url']?>/inc/seccode.php?a=showseccode" alt="单击图片换张图片" border="0" onclick="this.src='<?=$options['url']?>/inc/seccode.php?a=showseccode&update=' + Math.random()" /> *
			</div>
			<? } ?>
			<div class="row">
			<textarea class="text" name="content" rows="10" style="width:656px;"></textarea>
			</div>
			<div class="row">
			<input type="submit" class="submit" value="发表评论" />
			</div>
			</form>
		</div>
		<? } ?>
		<? } else{?>
		<div class="close_comment">评论功能已被博主关闭！</div>
		<? } ?>
	</div>
	<?php
	require 'sidebar.php';
	?>
	<div class="fixed"></div>
</div>
<?php
	require 'footer.php';
?>