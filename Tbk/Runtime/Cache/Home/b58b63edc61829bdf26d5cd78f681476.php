<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
 
<meta charset="UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge" />
<link href="/Tbk/Public/Css/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/Tbk/Public/Css/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/Tbk/Public/Css/style.css" rel="stylesheet" type="text/css" />
<link href='/Tbk/Public/favicon.ico' rel='shortcut icon'/>
<script  src="/Tbk/Public/Js/Ueditor/third-party/jquery-1.10.2.min.js"></script> 
 

<link href="/Tbk/Public/Css/blog/blog.css" rel="stylesheet">
<meta name="keywords" content=<?php echo ($options[1][option_value]); ?> />
<meta name="description" content=<?php echo ($options[3][option_value]); ?> />
<title><?php echo ($options[2][option_value]); ?></title>

</head>
<body>
	<div class="blog-masthead">
		<div class="container">
			 <nav class="blog-nav">
<a class= "blog-nav-item" href="/"><span>首页</span>
 </a>
 <?php if(is_array($sidebar)): foreach($sidebar as $key=>$sidebar): ?><a class= "blog-nav-item" href="<?php echo U('index/menu',array('ID'=>$sidebar[id]));?>"><span><?php echo ($sidebar["label"]); ?></span>
 </a><?php endforeach; endif; ?>
</nav> 
		</div>
	</div>
	<div class="container">
		<aside class="blog-header">
			 <h1 class="blog-title"><?php echo ($options[2][option_value]); ?></h1>
<p class="lead blog-description"><?php echo ($options[3][option_value]); ?></p> 
		</aside>
		<div class="row" id="post-list">
			
<div class="col-sm-8 blog-main">
	<div class="blog-post">
		<?php if(is_array($posts)): foreach($posts as $key=>$posts): ?><article class="blog-post">
			<h2>
				<a href="<?php echo U('Title/index',array('ID'=>$posts[num_iid]));?>"><p><?php echo ($posts["title"]); ?></p></a>
			</h2>
			<p>
				<img src="<?php echo ($posts["pict_url"]); ?>" class="img-responsive center-block" />
			</p>

			<p>价格：<?php echo ($posts["reserve_price"]); ?>元 本月销量：<?php echo ($posts["volume"]); ?></p>
			<p>
				优惠券：<a href="<?php echo ($posts["activity_url"]); ?>" class="btn btn-success">点击领取</a> 链接：<a href="<?php echo ($posts["click_short_urls"]); ?>" class="btn btn-success">点击购买</a>
			</p>
			<p>优惠口令：<?php echo ($posts["click_pw"]); ?></p>
		</article><?php endforeach; endif; ?>
	</div>
	<nav>
		<ul class="pager">
			<hr />
			<div class="media">
				<h3>评论列表</h3>
				<?php if(is_array($comments)): foreach($comments as $key=>$comments): ?><ul class="media-list">
					<li class="media"><div class="media-left">
							<span class="media-object glyphicon glyphicon-user
glyphicon " aria-hidden="true"></span>
						</div>
						<div class="media-body">
							<h4><?php echo ($comments["comment_author"]); ?></h4>
							<small><?php echo ($comments["comment_date"]); ?></small>
							<div class="well" style="font-size: 14px;"><?php echo ($comments["comment_content"]); ?></div>
						</div></li>
				</ul><?php endforeach; endif; ?>
				<hr />
				<form class="form-horizontal" method="post" action="<?php echo U('Title/do_comment');?>">
					<div class="form-group  ">
						<label for="comment_author" class="col-sm-2 control-label">昵称</label>
						<div class="col-sm-6">
							<h3>
								<a id="username" href="<?php echo ($comment["comment_author_url"]); ?>"><?php echo ($user["user_nicename"]); ?></a>
							</h3>
							<input type="text" placeholder="昵称" class="form-control" id="comment_author" name="comment_author" required value="<?php echo ($comment["comment_author"]); ?>">

						</div>
					</div>
					<div class="form-group ">
						<label for="mailname" class="col-sm-2 control-label">邮箱 <span class="color-red"></span></label>
						<div class="col-sm-8">
							<input type="email" placeholder="邮箱地址" class="form-control" id="comment_author_email" name="comment_author_email" required value="<?php echo ($user["user_email"]); ?>">
						</div>
					</div>
					<div class="form-group ">
						<label for="comment_content" class="col-sm-2 control-label">内容</label>
						<div class="col-sm-8">
							<textarea class="form-control" rows="8" id="comment_content" name="comment_content" required value="<?php echo ($comment["comment_content"]); ?>"></textarea>
						</div>
					</div>
					<div class="form-group ">
						<input type="text" class="form-control sr-only" id="comment_author" name="comment_author" value="<?php echo ($user["user_login"]); ?>"> <input type="text"
							class="form-control sr-only" id="comment_post_ID" name="comment_post_ID" value="<?php echo ($posts["id"]); ?>"> <input type="text" class="form-control sr-only"
							id="comment_post_title" name="comment_post_title" value="<?php echo ($posts["post_title"]); ?>"> <input type="text" class="form-control sr-only"
							id="comment_author_url" name="comment_author_url" value="<?php echo ($posts["post_title"]); ?>"> <input type="text" class="form-control sr-only"
							id="comment_parent" name="comment_parent" value="0">
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary">
								<i class="icon-ok"></i>提交
							</button>
						</div>
					</div>
				</form>
			</div>
		</ul>
	</nav>
</div>
<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
	<div class="sidebar-module">
		<h4>热门文章</h4>
		<ol class="list-unstyled">
			<?php if(is_array($hot)): foreach($hot as $key=>$hot): ?><li><a href="<?php echo U('Title/index',array('ID'=>$hot[id]));?>"><?php echo ($hot["post_title"]); ?></a></li><?php endforeach; endif; ?>
		</ol>
	</div>
</div>
<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
	<div class="sidebar-module">
		<h4>最近更新</h4>
		<ol class="list-unstyled">
			<?php if(is_array($update)): foreach($update as $key=>$update): ?><li><a href="<?php echo U('Title/index',array('ID'=>$update[id]));?>"><?php echo ($update["post_title"]); ?></a></li><?php endforeach; endif; ?>
		</ol>
	</div>
</div>

		</div>

	</div>
	 <footer class="blog-footer">
	<p>Copyright © 1999 - 2016 <a href="http://www.1668s.com/" title="窝呆" target="_blank">窝呆</a></p>
</footer> 
</body>
</html>