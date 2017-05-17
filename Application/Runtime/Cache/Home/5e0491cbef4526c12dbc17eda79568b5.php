<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户信息一览</title>
<link rel="stylesheet"
	href=http://localhost:8080/freeBicycle/Public/bootstrap/css/bootstrap.min.css>
<script type="text/javascript"
	src="http://localhost:8080/freeBicycle/Public/bootstrap/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript"
	src="http://localhost:8080/freeBicycle/Public/bootstrap/js/bootstrap.min.js"></script>
<style type="text/css">
#topbtn .glyphicon {
	margin-right: 5px;
}

.search {
	height: 33px;
	margin-left: 10px;
	padding: 0;
}

#searchForm input {
	float: right;
	width: 50%;
}

.table tr th {
	text-align: center;
}
.pagination:HOVER {
	cursor: pointer;
}
</style>
<script type="text/javascript">
	function resetSearch(){
		$("#search").val("");
		$("#btnSearch").click();
	}
	
	//type值为0转到下一页，为-1转到上一页，为正到指定页
	function turnPage(page, total, pageNo) {
		if (pageNo < 0) {
			pageNo += page;
		} else if (pageNo == 0) {
			pageNo = page + 1;
		}
		location.href = "http://localhost:8080/freeBicycle/index.php/Home/WYX/showUserList/pageNo/"
				+ pageNo;
	}
	$(function(){
		var pageNo = <?php echo ($page["pageNo"]); ?>;
		var totalPage = <?php echo ($page["totalPage"]); ?>;
		switch(pageNo){
		case totalPage:
			$("#next").addClass("disabled").removeAttr("onclick");
			break;
		case 1:
			$("#previous").addClass("disabled").removeAttr("onclick");
			break;
		}
		$(".page").each(function(index){
			if(index == pageNo-1){
				$(this).addClass("active");
			}
		});
	});
	
</script>
</head>
<body>
	<div class="container">
		<div id="topbtn" class="btn-group" role="group" style="width: 98%; margin: 10px 10px 0 10px;">
			<button type="button" class="btn btn-default"
				onclick="turnPage(1,1);">
				<span class="glyphicon glyphicon-refresh"></span>刷新
			</button>
			<button type="button" class="btn btn-default" onclick="addedit(0);">
				<span class="glyphicon glyphicon-edit"></span>操作
			</button>
			<button type="button" class="btn btn-default">
				<span class="glyphicon glyphicon-file"></span>导出Excel
			</button>
			<!-- 条件搜索 -->
			<form id="searchForm" action="http://localhost:8080/freeBicycle/index.php/Home/WYX/showUserList" method="post">
				<div class="input-group">
					<input type="text" class="form-control" id="search" name="search" value="<?php echo ($page["search"]); ?>" placeholder="输入用户编号、名称、手机号码或平台名称来搜索">
					<span class="input-group-btn">
						<button id="btnSearch" class="btn btn-default form-control" type="submit">
							<span class="glyphicon glyphicon-search"></span>
							搜索
						</button>
					</span>
					<span class="input-group-btn">
						<a id="reset" class="btn btn-default" href="javascript:resetSearch()">重置</a>
					</span>
				</div>
			</form>
		</div>
		<table
			class="table table-striped table-bordered table-condensed text-center table-hover"
			style="width: 98%; margin: 10px 10px 0 10px;">
			<tr>
				<th></th>
				<th><input type="checkbox" name="nums" /></th>
				<th>用户编号</th>
				<th>用户名称</th>
				<th>性别</th>
				<th>手机号码</th>
				<th>平台</th>
				<th>账号冻结</th>
			</tr>
			<?php if(is_array($page["rows"])): $i = 0; $__LIST__ = $page["rows"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rows): $mod = ($i % 2 );++$i;?><tr>
				<td style="text-align: center"><?php echo ($i); ?></td>
				<td style="text-align: center"><input type="checkbox" name="No"
					value="<?php echo ($rows["u_id"]); ?>"></td>
				<td><?php echo ($rows["account"]); ?></td>
				<td><?php echo ($rows["uname"]); ?></td>
				<td><script>
								if(<?php echo ($rows["gender"]); ?>){
									document.write("男");
								}else{
									document.write("女");
								}
    						</script></td>
				<td><?php echo ($rows["phone"]); ?></td>
				<td><?php echo ($rows["tname"]); ?></td>
				<td><script>
								if(<?php echo ($rows["freeze"]); ?>){
									document.write("是");
								}else{
									document.write("否");
								}
    						</script></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
		<!-- 翻页按钮 -->
		<nav aria-label="Page navigation" class="text-center">
			<ul class="pagination">
				<li id="previous" onclick="turnPage(<?php echo ($page["pageNo"]); ?>,<?php echo ($page["totalPage"]); ?>,-1)">
					<span>
						<span aria-hidden="true">&laquo;</span>
					</span>
				</li>
				<?php $__FOR_START_2929__=0;$__FOR_END_2929__=$_SESSION['userlist']['totalPage'];for($i=$__FOR_START_2929__;$i < $__FOR_END_2929__;$i+=1){ ?><li class="page">
						<a href="javascript:turnPage(<?php echo ($page["pageNo"]); ?>,<?php echo ($page["totalPage"]); ?>,<?php echo ($i+1); ?>)"><?php echo ($i+1); ?></a>
					</li><?php } ?>
				<li id="next" onclick="turnPage(<?php echo ($page["pageNo"]); ?>,<?php echo ($page["totalPage"]); ?>,<?php echo ($page["pageNo"]); ?>+1)">
					<span>
						<span aria-hidden="true">&raquo;</span>
					</span>
				</li>
				<li><span>共<?php echo ($page["total"]); ?>条数据</span></li>
			</ul>
		</nav>
	</div>
	<!-- 模态框 -->
	<div class="modal fade" tabindex="-1" role="dialog" id="addandedit">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">更改状态</h4>
				</div>
				<div class="modal-body">
					<form
						action="http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/BicycleListEdit"
						method="post" class="text-center">
						<input type="hidden" name="ctr" id="ctr" />
						<div class="form-group form-inline">
							<div class="input-group ">
								<div class="input-group-addon">单车编号</div>
								<input id="no" name="no" type="text" class="form-control"
									onblur="inblur(this,/^[0-9]{5}$/)" /> <span
									class="glyphicon form-control-feedback"></span>
							</div>
						</div>
						<div class="form-group form-inline">
							<div class="input-group ">
								<div class="input-group-addon">单车车型</div>
								<input id="model" name="model" type="text" class="form-control"
									onblur="inblur(this,/([^\s])/)" /> <span
									class="glyphicon form-control-feedback"></span>
							</div>
						</div>
						<div class="form-group form-inline">
							<div class="input-group ">
								<div class="input-group-addon">投放时间</div>
								<input id="puttime" name="puttime" type="text"
									class="form-control input-append date" readonly /> <span
									class="glyphicon form-control-feedback"></span>
							</div>
						</div>
						<div class="form-group form-inline">
							<div class="input-group">
								<div class="input-group-addon">单车状态</div>
								<select id="name" name="name" class="form-control"
									style="width: 170px">
									<option value="6">正常</option>
									<option value="1">低频</option>
									<option value="3">异常</option>
									<option value="5">消失</option>
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default">取消</button>
							<input type="submit" class="btn btn-primary" value="确认">
						</div>
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</body>
</html>