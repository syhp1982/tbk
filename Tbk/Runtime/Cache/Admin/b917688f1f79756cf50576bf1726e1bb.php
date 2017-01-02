<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
 
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge" />
<link href='/Tbk/Public/favicon.ico' rel='shortcut icon'>
<link href="/Tbk/Public/css/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="/Tbk/Public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="/Tbk/Public/css/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/Tbk/Public/css/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/Tbk/Public/css/index.css" rel="stylesheet" type="text/css" />
<link href="/Tbk/Public/css/style.css" rel="stylesheet" type="text/css" />
<script  src="/Tbk/Public/Js/Ueditor/third-party/jquery-1.10.2.min.js"></script> 
<script  src="/Tbk/Public/Js/bootstrap/bootstrap.min.js"></script> 
<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
 

<link href="/Tbk/Public/css/admin/dashboard.css" rel="stylesheet">
<link href="/Tbk/Public/css/admin/theme.css" rel="stylesheet">
<title>窝呆管理后台</title>

</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		 <div class="container-fluid">
	<div class="navbar-header">
		<a class="navbar-brand" href="<?php echo U('Index/index');?>"> <img
			src="/Tbk/Public/images/logo.png" alt="logo" />
		</a>
	</div>
	<div id="navbar" class="navbar-collapse collapse">
		<ul class="nav navbar-nav navbar-right">
			<li><a href="#" class="dropdown-toggle"
				data-toggle="dropdown"> <img alt=""
					src="/Tbk/Public/images/user/<?php echo ($userinfo[pic]); ?>" /> <span
					class="username"><?php echo ($userinfo[nickname]); ?></span> <i class="icon-user"></i>
			</a></li>
			<li><a href=/Tbk/index.php/Admin/Login/logout"><i class="icon-key"></i>
					退出</a></li>
		</ul>
	</div>
</div> 
	</nav>
	<div class="container-fluid">
	<div class="row">
		<aside class="col-sm-3 col-md-2 sidebar">
			 <ul class="nav nav-sidebar"  id="sub-menu">
	<?php echo ($sidebar); ?>
</ul>
<script>
	$(function() {
		$('#sub-menu').metisMenu();	
	});
</script>
 
		</aside>
		<div class="embed-responsive embed-responsive-4by3">
			<iframe  class="embed-responsive-item"   name="myMainName"  ></iframe> 
		</div>
		<div class="col-md-10">
		 <script type="text/javascript">
$("document").ready(function(){ 
	  $(".nav-sidebar li").click(function(){
	    $(".nav-sidebar li").removeClass("active");//首先移除全部的active
	    $(this).addClass("active");//选中的添加acrive
	 });
	 });
</script>

<script type="text/javascript" charset="utf-8" src="/Tbk/Public/Js/Ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Tbk/Public/Js/Ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/Tbk/Public/Js/Ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="/Tbk/Public/Js/jquery/metisMenu/jquery.metisMenu.js"></script>
<script type="text/javascript" src="/Tbk/Public/Js/script.js"></script>
<footer>
	Copyright © 1999 - 2016 <a href="http://www.1668s.com/" title="窝呆" target="_blank">窝呆</a>
</footer> 
		</div>
	</div>
	</div>
</body>
</html>