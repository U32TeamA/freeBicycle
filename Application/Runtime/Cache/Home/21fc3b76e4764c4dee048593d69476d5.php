<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href=http://localhost:8080/freeBicycle/Public/bootstrap/css/bootstrap.css>
		<style type="text/css">
			.table tr th{text-align:center;}
			.table{width:98%;margin:10px 10px 0 10px;}
		</style>
		<script type="text/javascript" src=http://localhost:8080/freeBicycle/Public/bootstrap/js/jquery-1.9.1.min.js></script>
		<script type="text/javascript" src=http://localhost:8080/freeBicycle/Public/bootstrap/js/bootstrap.min.js></script>
		<script type="text/javascript">
			//修改密码
			function editpassword(){
				$("#addandedit").modal("toggle");
			}
		</script>
	</head>
	<body>
		<div class="container">
			<table class="table table-striped table-bordered table-condensed text-center table-hover">
				<tr><th><input type="checkbox" name="nums"></th><th>管理员账户</th><th>管理员密码</th><th>操作</th></tr>
				<?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
						<td><input type="checkbox" name="num"></td>
						<td><?php echo ($row["ad_account"]); ?></td>
						<td><?php echo ($row["ad_password"]); ?></td>
						<td><a href="javascript:editpassword();">修改密码</a></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
		</div>
		<!-- 模态框 -->
		<div class="modal fade" tabindex="-1" role="dialog" id="addandedit">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">修改密码</h4>
		      </div>
		      <div class="modal-body">
		      	<form action="http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/passwordEdit" method="post" class="text-center">
		        	<div class="form-group form-inline">
						<div class="input-group ">
							<div class="input-group-addon">用户帐号</div>
							<input id="account" name="account" type="text" class="form-control" value="<?php echo ($row["ad_account"]); ?>" readonly/>
							<span class="glyphicon form-control-feedback"></span>
						</div>
					</div>
					<div class="form-group form-inline">
						<div class="input-group ">
							<div class="input-group-addon">用户密码</div>
							<input id="password" name="password" type="text" class="form-control" value="<?php echo ($row["ad_password"]); ?>"/>
							<span class="glyphicon form-control-feedback"></span>
						</div>
					</div>
					<div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
			        <input type="submit" class="btn btn-primary" value="确认">
			      </div>
		        </form>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div>
	</body>
</html>