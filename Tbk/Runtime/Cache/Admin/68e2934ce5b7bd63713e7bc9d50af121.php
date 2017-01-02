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
				
<h1 class="page-header">文章管理</h1>
<div class="clearfix">
	<div class="form-group">
		<a href="<?php echo U('Posts/Posts_add');?>">
			<button type="button" class="btn btn-success">
				添加<i class="icon-plus"></i>
			</button>
		</a>
	</div>
</div>
<div class="form-group">
	<table class="table table-bordered table-condensed text-nowrap">
		<thead>
			<tr role="row">
				<th style="width: 24px;" class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label=""><div class="checker">
						<span><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"></span>
					</div></th>
				<th class="sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1"
					aria-label="Username: activate to sort column ascending" style="width: 169px;">序号</th>
				<th class="hidden-480 sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 176px;" aria-label="Joined">文章标题</th>
				<th class="hidden-480 sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="Email" style="width: 298px;">查看次数</th>
				<th class="hidden-480 sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 176px;" aria-label="Joined">评论次数</th>
				<th class="hidden-480 sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 176px;" aria-label="Joined">发布时间</th>
				<th class="hidden-480 sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 176px;" aria-label="Joined">修改时间</th>
				<th class="hidden-480 sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1"
					aria-label="Points: activate to sort column ascending" style="width: 116px;">状态</th>
				<th class="hidden-480 sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="Joined" style="width: 176px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($posts)): foreach($posts as $key=>$posts): ?><tr>
				<td class=" sorting_1"><div class="checker">
						<span><input type="checkbox" class="checkboxes" value="1"></span>
					</div></td>
				<td><span><?php echo ($posts["id"]); ?></span></td>
				<td><span><?php echo ($posts["post_title"]); ?></span></td>
				<td><span><?php echo ($posts["comment_count"]); ?></span></td>
				<td><span>1</span></td>
				<td><span><?php echo ($posts["post_date"]); ?></span></td>
				<td><span><?php echo ($posts["post_modified"]); ?></span></td>
				<td><span><?php echo ($posts["post_status"]); ?></span></td>
				<td><span><a href="<?php echo U('Posts/posts_edit',array('ID'=>$posts[id]));?>"><button type="button" class="btn  btn-info">修改</button></a></span></td>
			</tr><?php endforeach; endif; ?>
		</tbody>
	</table>
</div>
			
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