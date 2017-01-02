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
 

<link href="/Tbk/Public/Css/admin/theme.css" rel="stylesheet">

</head>
<body>
	<div class="container-fluid" >
	<div class="row" >
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				
<h1 class="page-header"><?php echo ($page_title); ?></h1>
<form method="post" action="<?php echo U('Posts/doedit',array('ID'=>$posts[id]));?>" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-8">
			<div class="form-group">
				<label for="mailname" class="col-sm-2 control-label">栏目</label>
				<?php if(is_array($nav)): foreach($nav as $key=>$nav): ?><label for="mailname" class="checkbox-inline"> <input type="checkbox" id="inlineCheckbox1" value="$nav.id">
					<?php echo ($nav["label"]); ?>
				</label><?php endforeach; endif; ?>
			</div>
			<div class="form-group">
				<label for="post_title" class="col-sm-2 control-label">标题</label>
				<div class="col-sm-10">
					<input type="text" placeholder="标题" class="form-control" id="post_title" name="post_title" required value="<?php echo ($posts["post_title"]); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="post_date" class="col-sm-2 control-label">发布时间</label>
				<div class="col-sm-10">
					<input type="text" placeholder="发布时间" class="form-control" id="post_date" name="post_date" readonly value="<?php echo ($posts["post_date"]); ?>"/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="post_author" class="col-sm-2 control-label">作者</label>
				<div class="col-sm-10">
					<input type="text" placeholder="作者" class="form-control" id="post_author" name="post_author" required value="<?php echo ($posts["post_author"]); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="mailname" class="col-sm-2 control-label">文章来源</label>
				<div class="col-sm-10">
					<input type="url" placeholder="文章来源" class="form-control" id="guid" name="guid" required value="<?php echo ($posts["guid"]); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="post_info" class="col-sm-2 control-label">摘要</label>
				<div class="col-sm-10">
					<input type="text" placeholder="摘要" class="form-control" id="post_info" name="post_info" required value="<?php echo ($posts["post_info"]); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="post_content" class="col-sm-2 control-label">内容</label>
				<div class="col-sm-10">
					<script id="editor" type="text/plain" name="post_content">
					<p><?php echo ($posts["post_content"]); ?></p>
				</script>
				</div>
			</div>
			<div class="form-group">
				<label for="post_status" class="col-sm-2 control-label">状态</label>
				<div class="col-sm-10">
					<label class="radio-inline"> <input type="radio" id="post_status" name="post_status" value="1"
					<?php if($posts["post_status"] == 1): ?>checked<?php endif; ?>>审核
					</label> <label class="radio-inline"> <input type="radio" id="post_status" name="post_status" value="0"
					<?php if($posts["post_status"] == 0): ?>checked<?php endif; ?>>待审核
					</label>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">
						<i class="icon-ok"></i>保存
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(function() {
		var ue = UE.getEditor('editor');
	})
</script> 			
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