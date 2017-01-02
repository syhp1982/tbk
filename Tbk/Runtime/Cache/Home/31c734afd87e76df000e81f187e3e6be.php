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
			 <?php if(is_array($posts)): foreach($posts as $key=>$posts): ?><div class="col-md-4 ">
<article class="blog-post">
	<p>
		<img src="<?php echo ($posts["pict_url"]); ?>" class="img-responsive center-block" />
	</p>
	<h2>
		<a href="<?php echo U('Title/index',array('ID'=>$posts[num_iid]));?>"><p><?php echo ($posts["title"]); ?></p></a>
		</h2>
	<p>价格：<?php echo ($posts["reserve_price"]); ?>元 本月销量：<?php echo ($posts["volume"]); ?></p>
	<p>
		优惠券：<a href="<?php echo ($posts["activity_url"]); ?>" class="btn btn-success">点击领取</a> 链接：<a href="<?php echo ($posts["click_short_urls"]); ?>" class="btn btn-success">点击购买</a>
	</p>
	<p>优惠口令：<?php echo ($posts["click_pw"]); ?></p>
	</article>
</div><?php endforeach; endif; ?>
		<nav>
			<ul class="pagination pagination-lg">
				<?php print_r($page) ?>
			</ul>
		</nav>

		</div>

	</div>
	 <footer class="blog-footer">
	<p>Copyright © 1999 - 2016 <a href="http://www.1668s.com/" title="窝呆" target="_blank">窝呆</a></p>
</footer> 
</body>
</html>