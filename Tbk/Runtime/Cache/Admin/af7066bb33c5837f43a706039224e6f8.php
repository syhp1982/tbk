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
				
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a data-toggle="tab" href="#restore" aria-controls="restore" role="tab"><?php echo ($page_title); ?></a></li>
	<li role="presentation"><a data-toggle="tab" href="#backup" aria-controls="backup" role="tab"><?php echo ($page_title2); ?></a></li>
</ul>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active" id="restore">
		<div class="form-group   active">
			<table class="table table-bordered table-condensed text-nowrap">
				<thead>
					<tr role="row">
						<th class="col-xs-1" rowspan="1" colspan="1">备份名称</th>
						<th class="col-xs-2" rowspan="1" colspan="1">备份大小</th>
						<th class="col-xs-2" rowspan="1" colspan="1">备份时间</th>
						<th class="col-xs-2" rowspan="1" colspan="1">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($backups)): $i = 0; $__LIST__ = $backups;if( count($__LIST__)==0 ) : echo "暂时没有备份" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr class="collapsed">
						<td><span> <?php echo ($val["name"]); ?></span></td>
						<td><span><?php echo ($val["total_size"]); ?>kb</span></td>
						<td><span><?php echo ($val["date_str"]); ?></span></td>
						<td><a href="<?php echo U('Backup/delBackup', array('backup_name'=>$val['name']));?>" class="btn   btn-danger" data-msg="确定删除吗？">删除</a> | <a
							href="<?php echo U('Backup/restore', array('backup_name'=>$val['name']));?>"  class="btn btn-info " data-msg="确定恢复吗？">恢复</a>
							 | <a
							href="<?php echo U('Backup/download', array('backup_name'=>$val['name']));?>" class="btn btn-warning" >下载</a>
							</td>
					</tr><?php endforeach; endif; else: echo "暂时没有备份" ;endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane fade" id="backup">
		<div class="form-group ">
			<form method="post" action="<?php echo U('Backup/dobackup');?>"  class="form-horizontal">
				<div class="col-sm-8">
					<div class="form-group">
						<label for="blogname" class="col-sm-2 control-label">分卷大小</label>
						<div class="col-sm-4">
							<input type="number" placeholder="分卷大小" class="form-control" id="sizelimit" name="sizelimit" value="10240"  required /> 
						</div>
						<div class="col-sm-4">
							<label for="blogname" class="control-label"> K;(推荐10M以下)</label>
						</div>
					</div>
					<div class="form-group">
						<label for="blogname" class="col-sm-2 control-label">备份名称</label>
						<div class="col-sm-4">
							<input type="text" placeholder="备份名称" class="form-control" id="backup_name" name="backup_name"  value="窝呆备份"  required />
						</div>
					</div>

					<div class="form-group">
						<label for="blogname" class="col-sm-2 control-label">备份类型</label>
						<div class="col-sm-10">
							<button class="btn btn-primary"  name="backup_type"  type="button" data-toggle="collapse"  data-target="#showtables" aria-expanded="false" aria-controls="showtables">
								自定义备份</button>
						</div>
					</div>
					<div class="form-group">
						<div class="collapse"  id="showtables"">
							<div class="col-sm-2">
								<label><input class="selectall"  name="selectall"  checked="checked"type="checkbox"  />选择全部</label>
							</div>
							<div class="col-sm-10">
								<?php if(is_array($tables)): $i = 0; $__LIST__ = $tables;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 5 );++$i;?><label class="checkbox-inline" style="width: 200px;">
								 <input name="backup_tables[<?php echo ($val); ?>]"  type="checkbox"  value="-1"  checked="checked" class="checkitem" />&nbsp;&nbsp;<?php echo ($val); ?>
								</label><?php endforeach; endif; else: echo "" ;endif; ?>
							</div>
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
			</form>
		</div>
	</div>
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