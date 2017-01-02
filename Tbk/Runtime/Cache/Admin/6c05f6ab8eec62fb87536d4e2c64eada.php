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
 

<title>窝呆管理后台</title>
<link href="/Tbk/Public/Css/admin/signin.css" rel="stylesheet">

</head>
<body>
	<div class="container-fluid" >
	<div class="row" >
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				
	<form name="loginform" class="form-signin" action="<?php echo U('Admin/Login/dologin');?>" method="post">
	<h2 class="form-signin-heading">窝呆管理后台</h2>
	<div class="col-sm-12">
		<div class="form-group">
			<label for="user_login"  class="col-sm-4" >用户名</label> 
			<input class="col-sm-8 form-control"  id="user_login" type="text" placeholder="请输入用户名"  name="username" />
		</div>
		<div class="form-group">
			<label for="user_pass" class="col-sm-4">密码</label>
			 <input class="col-sm-8 form-control"  id="user_pass" type="password" placeholder="请输入密码" name="password" />
		</div>
		<div class="form-group">
			<div class="checkbox">
			<label class="col-sm-8" for="remember-me">
				<input id="remember-me"  type="checkbox"  value="记住密码"  >  记住密码	
				</label>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-lg btn-primary btn-block">登录</button>
		</div>
		</div>
	</form>
			
		</div>
	</div>
	<div class="navbar-fixed-bottom">
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
</body>
</html>