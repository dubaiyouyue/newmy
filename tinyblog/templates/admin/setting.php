<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<table class="tb4" cellspacing="0"><form action="admin.php?m=setting&a=updatesetting&type=<?=$type?>" method="post">
	<tr><td colspan="2"><strong><a href="admin.php?m=setting&type=basic">基本设置</a></strong>
<strong><a href="admin.php?m=setting&type=display">显示设置</a></strong>
<strong><a href="admin.php?m=setting&type=user">用户设置</a></strong>
<strong><a href="admin.php?m=setting&type=comment">评论设置</a></strong>
<strong><a href="admin.php?m=setting&type=tb">引用设置</a></strong>
<strong><a href="admin.php?m=setting&type=link">链接设置</a></strong>
<strong><a href="admin.php?m=setting&type=sidebar">侧边栏设置</a></strong>
<strong><a href="admin.php?m=setting&type=time">时间设置</a></strong>
<strong><a href="admin.php?m=setting&type=func">功能设置</a></strong>
<strong><a href="admin.php?m=setting&type=seo">搜索引擎优化</a></strong>
<strong><a href="admin.php?m=setting&type=attach">附件设置</a></strong></td></tr>
<?php if(!$type || $type == 'basic') { ?>
<tr><td width="20%">网站URL</td>
  <td><input class=text type="text" name="options[url]" size="45" value="<?php echo $options['url']?>" /></td>
</tr>
<tr><td>&nbsp;</td><td>一般不需修改，系统自动获得</td></tr>
<tr><td>Blog标题</td>
  <td><input class=text type="text" name="options[blog_title]" size="45" value="<?php echo $options['blog_title']?>" /></td>
</tr>
<tr><td>Blog名称</td>
  <td><input class=text type="text" name="options[blog_name]" size="45" value="<?php echo $options['blog_name']?>" /></td>
</tr>
<tr>
  <td>站点描述</td>
  <td><input class=text type="text" name="options[blog_description]" size="45" value="<?php echo $options['blog_description']?>" /></td>
</tr>
<tr>
  <td>关键字</td>
  <td><input class=text type="text" name="options[blog_keywords]" size="45" value="<?php echo $options['blog_keywords']?>" /></td>
</tr>
<?php } ?>
<?php if(!$type || $type == 'display') { ?>
<tr>
  <td width="20%">浏览模式</td>
  <td>
正常模式<input class="radio" type="radio" <?php if ($options['viewmode']=='normal') echo "checked=\"checked\"";?> value="normal" name="options[viewmode]" />
列表模式<input class="radio" type="radio" <?php if ($options['viewmode']=='list') echo "checked=\"checked\"";?> value="list" name="options[viewmode]" /></td>
</tr>
<tr>
  <td>正常模式显示文章个数</td>
  <td><input class=text size="1" type="text" name="options[normalnum]" value="<?php echo $options['normalnum']?>" /></td>
</tr>
<tr>
  <td>列表模式显示文章个数</td>
  <td><input class=text size="1" type="text" name="options[listnum]" value="<?php echo $options['listnum']?>" /></td>
</tr>
<tr>
  <td>是否显示上一篇下一篇</td>
  <td><select name="options[show_pre_next]">
      <option value="1" <? if($options['show_pre_next']){ echo 'selected';}?> >是</option>
      <option value="0" <? if(!$options['show_pre_next']){ echo 'selected';}?>>否</option></select></td>
</tr>
<tr>
  <td>是否显示相关文章</td>
  <td><select name="options[show_relate]">
      <option value="1" <? if($options['show_relate']){ echo 'selected';}?> >是</option>
      <option value="0" <? if(!$options['show_relate']){ echo 'selected';}?>>否</option></select></td>
</tr>
<tr>
  <td>相关文章显示个数</td>
  <td><input class=text size="1" type="text" name="options[relatenum]" value="<?php echo $options['relatenum']?>" /></td>
</tr>
<?php } ?>
<?php if(!$type || $type == 'user') { ?>
<tr>
  <td>是否关闭注册</td>
  <td><select name="options[close_reg]">
                        <option value="1" <? if($options['close_reg']){ echo 'selected';}?> >是</option>
                        <option value="0" <? if(!$options['close_reg']){ echo 'selected';}?>>否</option></select></td>
</tr>
<tr>
  <td>注册是否开启验证码</td>
  <td><select name="options[open_seccode]">
      <option value="1" <? if($options['open_seccode']){ echo 'selected';}?> >是</option>
      <option value="0" <? if(!$options['open_seccode']){ echo 'selected';}?>>否</option></select>
</td>
</tr>
<tr>
  <td>注册限制的用户名</td>
  <td><textarea name="options[ban_user]"  class="text" cols="40" rows="5"><?=$options['ban_user']?></textarea></td>
</tr>
<?php } ?>
<?php if(!$type || $type == 'comment') { ?>
<tr>
  <td>评论是否需要审核</td>
  <td><select name="options[need_approve]">
      <option value="1" <? if($options['need_approve']){ echo 'selected';}?> >是</option>
      <option value="0" <? if(!$options['need_approve']){ echo 'selected';}?>>否</option></select></td>
</tr>
<tr>
  <td>是否关闭评论</td>
  <td><select name="options[close_comment]">
      <option value="1" <? if($options['close_comment']){ echo 'selected';}?> >是</option>
      <option value="0" <? if(!$options['close_comment']){ echo 'selected';}?>>否</option></select></td>
</tr>
<tr>
  <td>关闭游客评论</td>
  <td><select name="options[close_guestcomment]">
      <option value="1" <? if($options['close_guestcomment']){ echo 'selected';}?> >是</option>
      <option value="0" <? if(!$options['close_guestcomment']){ echo 'selected';}?>>否</option></select></td>
</tr>
<tr>
  <td>是否显示评论</td>
  <td><select name="options[show_comment]">
      <option value="1" <? if($options['show_comment']){ echo 'selected';}?> >是</option>
      <option value="0" <? if(!$options['show_comment']){ echo 'selected';}?>>否</option></select></td>
</tr>
<tr>
  <td width="20%">评论每页显示数</td>
  <td><input class=text size="1" type="text" name="options[commentsnum]" value="<?php echo $options['commentsnum']?>" /></td>
</tr>
<tr>
  <td>单篇文章评论每页显示数</td>
  <td><input class=text size="1" type="text" name="options[articlecommentsnum]" value="<?php echo $options['articlecommentsnum']?>" /></td>
</tr>
<tr>
  <td>评论是否显示验证码</td>
  <td>是<input class="radio" type="radio" <?php if ($options['commentseccode']==1) echo "checked=\"checked\"";?> value="1" name="options[commentseccode]" />
否<input class="radio" type="radio" <?php if ($options['commentseccode']==0) echo "checked=\"checked\"";?> value="0" name="options[commentseccode]" /></td>
</tr>
<?php } ?>
<?php if(!$type || $type == 'tb'){ ?>
<tr>
  <td width="20%">引用每页显示数</td>
  <td><input class=text size="1" stype="text" name="options[tbnum]" value="<?php echo $options['tbnum']?>" /></td>
</tr>
<tr>
  <td>是否允许引用</td>
  <td>允许引用<input class="radio" type="radio" <?php if ($options['istb']==1) echo "checked=\"checked\"";?> value="1" name="options[istb]" />
禁止引用<input class="radio" type="radio" <?php if ($options['istb']==0) echo "checked=\"checked\"";?> value="0" name="options[istb]" /></td>
</tr>
<?php } ?>
<?php if(!$type || $type == 'link') { ?>
<tr>
  <td width="20%">链接每页显示数</td>
  <td><input class=text size="1" stype="text" name="options[linknum]" value="<?php echo $options['linknum']?>" /></td>
</tr>
<?php } ?>
<?php if(!$type || $type == 'sidebar'){ ?>
<tr>
<tr>
  <td width="20%">侧边栏最新文章显示条数</td>
  <td><input class=text size="1" stype="text" name="options[recentarticlelistnum]" value="<?php echo $options['recentarticlelistnum']?>" /></td>
</tr>
<tr>
  <td>侧边栏最新评论显示条数</td>
  <td><input class=text size="1" stype="text" name="options[recentcommentlistnum]" value="<?php echo $options['recentcommentlistnum']?>" /></td>
</tr>
<tr>
  <td>侧边栏最新文章显示字数</td>
  <td><input class=text size="1" stype="text" name="options[recentarticlecharnum]" value="<?php echo $options['recentarticlecharnum']?>" /></td>
</tr>
<tr>
  <td>侧边栏最新评论显示字数</td>
  <td><input class=text size="1" stype="text" name="options[recentcommentcharnum]" value="<?php echo $options['recentcommentcharnum']?>" /></td>
</tr>
<tr>
  <td>侧边栏最新链接显示条数</td>
  <td><input class=text size="1" stype="text" name="options[recentlinklistnum]" value="<?php echo $options['recentlinklistnum']?>" /></td>
</tr>
<tr>
  <td>侧边栏最新链接显示字数</td>
  <td><input class=text size="1" stype="text" name="options[recentlinkcharnum]" value="<?php echo $options['recentlinkcharnum']?>" /></td>
</tr>
<tr><td>侧栏显示日历</td><td>是<input class="radio" type="radio" <?php if ($options['show_calendar']==1) echo "checked=\"checked\"";?> value="1" name="options[show_calendar]" />
否<input class="radio" type="radio" <?php if ($options['show_calendar']==0) echo "checked=\"checked\"";?> value="0" name="options[show_calendar]" /></td></tr>
<tr><td>侧栏显示分类</td><td>是<input class="radio" type="radio" <?php if ($options['show_categories']==1) echo "checked=\"checked\"";?> value="1" name="options[show_categories]" />
否<input class="radio" type="radio" <?php if ($options['show_categories']==0) echo "checked=\"checked\"";?> value="0" name="options[show_categories]" /></td></tr>
<tr><td>侧栏显示归档</td><td>是<input class="radio" type="radio" <?php if ($options['show_archives']==1) echo "checked=\"checked\"";?> value="1" name="options[show_archives]" />
否<input class="radio" type="radio" <?php if ($options['show_archives']==0) echo "checked=\"checked\"";?> value="0" name="options[show_archives]" /></td></tr>
<tr><td>侧栏显示评论</td><td>是<input class="radio" type="radio" <?php if ($options['show_recentcomments']==1) echo "checked=\"checked\"";?> value="1" name="options[show_recentcomments]" />
否<input class="radio" type="radio" <?php if ($options['show_recentcomments']==0) echo "checked=\"checked\"";?> value="0" name="options[show_recentcomments]" /></td></tr>
<tr><td>侧栏显示文章</td><td>是<input class="radio" type="radio" <?php if ($options['show_recentarticles']==1) echo "checked=\"checked\"";?> value="1" name="options[show_recentarticles]" />
否<input class="radio" type="radio" <?php if ($options['show_recentarticles']==0) echo "checked=\"checked\"";?> value="0" name="options[show_recentarticles]" /></td></tr>
<tr><td>侧栏显示统计信息</td><td>是<input class="radio" type="radio" <?php if ($options['show_statistics']==1) echo "checked=\"checked\"";?> value="1" name="options[show_statistics]" />
否<input class="radio" type="radio" <?php if ($options['show_statistics']==0) echo "checked=\"checked\"";?> value="0" name="options[show_statistics]" /></td></tr>
<tr><td>侧栏显示链接</td><td>是<input class="radio" type="radio" <?php if ($options['show_links']==1) echo "checked=\"checked\"";?> value="1" name="options[show_links]" />
否<input class="radio" type="radio" <?php if ($options['show_links']==0) echo "checked=\"checked\"";?> value="0" name="options[show_links]" /></td></tr>
<?php } ?>
<?php if(!$type || $type == 'seo') { ?>
<tr>
  <td width="20%">是否关闭伪静态</td>
  <td>开启<input class="radio" type="radio" <?php if ($options['ishtml']==1) echo "checked=\"checked\"";?> value="1" name="options[ishtml]" />
关闭<input class="radio" type="radio" <?php if ($options['ishtml']==0) echo "checked=\"checked\"";?> value="0" name="options[ishtml]" />&nbsp;如果您开启了伪静态，服务器将承受一定压力，本程序运行速度会相应减慢</td>
</tr>
<tr><td>分类目录前缀</td><td><input class="text" type="input" name="options[catedir]" value="<?php echo $options['catedir']?>" /> 不指定将默认为category</td></tr>
<tr><td> </td>
<td>
分类链接形式：http://您的url/分类目录/id 或 http://您的url/分类目录/自定义链接
</td>
</tr>
<tr><td>文章目录前缀</td><td><input class="text" type="input" name="options[artdir]" value="<?php echo $options['artdir']?>" /> 不指定将默认为archives</td></tr>
<tr><td> </td>
<td>
<tr><td>文章页后缀</td><td><select name="options[artsuffix]"><option value="0" <?php if ($options['artsuffix']==0) echo "checked=\"checked\"";?>>不指定</option><option <?php if ($options['artsuffix']=='html') echo "selected";?>>html</option><option <?php if ($options['artsuffix']=='shtml') echo "selected";?>>shtml</option><option <?php if ($options['artsuffix']=='php') echo "selected";?>>php</option><option <?php if ($options['artsuffix']=='asp') echo "selected";?>>asp</option></select> 自定义 <input class="text" type="text" name="options[selfartsuffix]" value="<?php echo $options['selfartsuffix']?>" /></td></tr>
<tr><td> </td>
<td>
文章链接形式：http://您的url/文章目录/id.文章页后缀 或 http://您的url/文章目录/自定义链接
</td>
</tr>
<?php } ?>
<?php if(!$type || $type == 'time') { ?>
<tr><td width="20%">时区选择</td><td>
<select name="options[timeoffset]">
                        <option value="-12" <? if($options['timeoffset'] == -12 ){ echo 'selected';} ?>>(标准时-12:00) 日界线西</option>
                        <option value="-11" <? if($options['timeoffset'] == -11 ){ echo 'selected';} ?>>(标准时-11:00) 中途岛、萨摩亚群岛</option>
                        <option value="-10" <? if($options['timeoffset'] == -10 ){ echo 'selected';} ?>>(标准时-10:00) 夏威夷</option>
                        <option value="-9" <? if($options['timeoffset'] == -9 ){ echo 'selected';} ?>>(标准时-9:00) 阿拉斯加</option>
                        <option value="-8" <? if($options['timeoffset'] == -8 ){ echo 'selected';} ?>>(标准时-8:00) 太平洋时间(美国和加拿大)</option>
                        <option value="-7" <? if($options['timeoffset'] == -7 ){ echo 'selected';} ?>>(标准时-7:00) 山地时间(美国和加拿大)</option>
                        <option value="-6" <? if($options['timeoffset'] == -6 ){ echo 'selected';} ?>>(标准时-6:00) 中部时间(美国和加拿大)、墨西哥城</option>
                        <option value="-5" <? if($options['timeoffset'] == -5 ){ echo 'selected';} ?>>(标准时-5:00) 东部时间(美国和加拿大)、波哥大</option>
                        <option value="-4" <? if($options['timeoffset'] == -4 ){ echo 'selected';} ?>>(标准时-4:00) 大西洋时间(加拿大)、加拉加斯</option>
                        <option value="-3.5" <? if($options['timeoffset'] == -3.5 ){ echo 'selected';} ?>>(标准时-3:30) 纽芬兰</option>
                        <option value="-3" <? if($options['timeoffset'] == -3 ){ echo 'selected';} ?>>(标准时-3:00) 巴西、布宜诺斯艾利斯、乔治敦</option>
                        <option value="-2" <? if($options['timeoffset'] == -2 ){ echo 'selected';} ?>>(标准时-2:00) 中大西洋</option>
                        <option value="-1" <? if($options['timeoffset'] == -1 ){ echo 'selected';} ?>>(标准时-1:00) 亚速尔群岛、佛得角群岛</option>
                        <option value="0" <? if($options['timeoffset'] == 0 ){ echo 'selected';} ?>>(格林尼治标准时) 西欧时间、伦敦、卡萨布兰卡</option>
                        <option value="1" <? if($options['timeoffset'] == 1 ){ echo 'selected';} ?>>(标准时+1:00) 中欧时间、安哥拉、利比亚</option>
                        <option value="2" <? if($options['timeoffset'] == 2 ){ echo 'selected';} ?>>(标准时+2:00) 东欧时间、开罗，雅典</option>
                        <option value="3" <? if($options['timeoffset'] == 3 ){ echo 'selected';} ?>>(标准时+3:00) 巴格达、科威特、莫斯科</option>
                        <option value="3.5" <? if($options['timeoffset'] == 3.5 ){ echo 'selected';} ?>>(标准时+3:30) 德黑兰</option>
                        <option value="4" <? if($options['timeoffset'] == 4 ){ echo 'selected';} ?>>(标准时+4:00) 阿布扎比、马斯喀特、巴库</option>
                        <option value="4.5" <? if($options['timeoffset'] == 4.5 ){ echo 'selected';} ?>>(标准时+4:30) 喀布尔</option>
                        <option value="5" <? if($options['timeoffset'] == 5 ){ echo 'selected';} ?>>(标准时+5:00) 叶卡捷琳堡、伊斯兰堡、卡拉奇</option>
                        <option value="5.5" <? if($options['timeoffset'] == 5.5 ){ echo 'selected';} ?>>(标准时+5:30) 孟买、加尔各答、新德里</option>
                        <option value="6" <? if($options['timeoffset'] == 6 ){ echo 'selected';} ?>>(标准时+6:00) 阿拉木图、 达卡、新亚伯利亚</option>
                        <option value="7" <? if($options['timeoffset'] == 7 ){ echo 'selected';} ?>>(标准时+7:00) 曼谷、河内、雅加达</option>
                        <option value="8" <? if($options['timeoffset'] == 8 ){ echo 'selected';} ?>>(北京时间) 北京、重庆、香港、新加坡</option>
                        <option value="9" <? if($options['timeoffset'] == 9 ){ echo 'selected';} ?> >(标准时+9:00) 东京、汉城、大阪、雅库茨克</option>
                        <option value="9.5" <? if($timeoffset == 9.5 ){ echo 'selected';} ?>>(标准时+9:30) 阿德莱德、达尔文</option>
                        <option value="10" <? if($timeoffset == 10 ){ echo 'selected';} ?>>(标准时+10:00) 悉尼、关岛</option>
                        <option value="11" <? if($timeoffset == 11 ){ echo 'selected';} ?>>(标准时+11:00) 马加丹、索罗门群岛</option>
                        <option value="12" <? if($timeoffset == 12 ){ echo 'selected';} ?>>(标准时+12:00) 奥克兰、惠灵顿、堪察加半岛</option>
                      </select>
</td></tr>
<tr><td>文章时间显示格式</td><td><input type="text" class="text" name="options[articledateformat]" value="<?=$options['articledateformat']?>" /></td></tr>
<tr><td>评论时间显示格式</td><td><input type="text" class="text" name="options[commentdateformat]" value="<?=$options['commentdateformat']?>" /></td></tr>
<tr><td>引用时间显示格式</td><td><input type="text" class="text" name="options[tbdateformat]" value="<?=$options['tbdateformat']?>" /></td></tr>
<?php } ?>
<?php if(!$type || $type == 'func'){?>
<tr>
  <td width="20%">是否关闭博客</td>
  <td>是<input class="radio" type="radio" <?php if ($options['close_blog']==1) echo "checked=\"checked\"";?> value="1" name="options[close_blog]" />
否<input class="radio" type="radio" <?php if ($options['close_blog']==0) echo "checked=\"checked\"";?> value="0" name="options[close_blog]" /></td>
</tr>
<tr>
  <td width="20%">关闭原因</td>
  <td><textarea name="options[close_reason]" class="text" cols="40" rows="5"><?=$options['close_reason']?></textarea></td>
</tr>
<tr>
  <td width="20%">页面压缩输出</td>
  <td>是<input class="radio" type="radio" <?php if ($options['iscompress']==1) echo "checked=\"checked\"";?> value="1" name="options[iscompress]" />
否<input class="radio" type="radio" <?php if ($options['iscompress']==0) echo "checked=\"checked\"";?> value="0" name="options[iscompress]" /></td>
</tr>
<?php } ?>
<?php if(!$type || $type == 'attach'){?>
<tr><td>附件路径</td><td><input type="text" class="text" name="options[attach_path]" value="<?=$options['attach_path']?>" size="45" /></td></tr>
<tr><td>允许上传附件类型</td><td><input type="text" class="text" name="options[attach_type]" value="<?=$options['attach_type']?>" size="45" /> </td></tr>
<tr><td>&nbsp;</td><td>系统默认禁止上传<?=$sys_config['ban_upfile_type']?>文件，可手动修改sys.config.php</td></tr>
<?php } ?>
<tr>
  <td width="20%">&nbsp;</td>
  <td><input class="submit" type="submit" value=" 提 交 " /></td>
</tr>
</form>
</table>
	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>