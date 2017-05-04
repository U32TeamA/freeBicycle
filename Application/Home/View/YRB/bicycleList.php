<?php
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>单车一览</title>
		<link rel="stylesheet" href=../../../../Public/bootstrap/css/bootstrap.min.css>
		<script type="text/javascript" src=../../../../Public/bootstrap/js/jquery-1.9.1.min.js></script>
		<script type="text/javascript" src=../../../../Public/bootstrap/js/bootstrap.min.js></script>
		<script type="text/javascript">
		//判断传入的值选择增加或者修改
		function addedit(type){
			if(type == 1){
				$("#ctr").val("1");
				$("#addandedit").modal("toggle");
			}else{
				var num = $("input[name=num]:checked");
				if(num.length != 1){
					alert("请选择一人进行操作！");
					return;
				}
				$("#ctr").val("0");
				//回填
				$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/BicycListLoad",{
					"enum":num.val()
				},function(data){
					$("#enum").val(num.val());
					$("#ename").val(data[0]['ename']);
					$("#epassword").val(data[0]['epassword']);
					$("#salary").val(data[0]['salary']);
					$("#job").val(data[0]['job']);
				},"json");
				$("#addandedit").modal("toggle");	
			}
		}
		</script>
	</head>
	<body>
		<div class="container">
			<div id="topbtn" class="btn-group" role="group" style="width:98%;margin:10px 10px 0 10px;">
    		  <button type="button" class="btn btn-default" onclick="addedit(1);"><span class="glyphicon glyphicon-plus"></span>新增</button>
    		  <button type="button" class="btn btn-default" onclick="addedit(0);"><span class="glyphicon glyphicon-edit"></span>修改</button>
    		  <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span>删除</button>
    		  <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-file"></span>导出Excel</button>
    		</div>
			<table class="table table-striped table-bordered table-condensed">
				<tr>
					<th><input type="checkbox"/></th><th>行程</th><th>状态</th><th>租赁开始时间</th><th>租赁结束时间</th><th>用户帐号</th>
				</tr>
				<volist name="page.rows" id="rows">
					<tr>
						<td><input type="checkbox"/></td>
    					<td>{$rows.joureny}</td>
    					<td>{$rows.name}</td>
    					<td>{$rows.begin}</td>
    					<td>{$rows.end}</td>
    					<td>{$rows.account}</td>
					</tr>
				</volist>
			</table>
			<!-- 翻页按钮 -->
			<nav aria-label="Page navigation" class="text-center">
			  <ul class="pagination">
			  	<li><a href="javascript:void(0);">第{$page.pageNo}页</a></li>
			    <li>
			      <a href="javascript:turnPage('{$page.pageNo}',-1);" aria-label="Previous">
			        <span aria-hidden="true">&laquo;</span>
			      </a>
			    </li>
			    <li><a href="javascript:turnPage('{$page.pageNo}',1);">1</a></li>
			    <li><a href="javascript:turnPage('{$page.pageNo}',2);">2</a></li>
			    <li><a href="javascript:turnPage('{$page.pageNo}',3);">3</a></li>
			    <li><a href="javascript:turnPage('{$page.pageNo}',4);">4</a></li>
			    <li><a href="javascript:turnPage('{$page.pageNo}',5);">5</a></li>
			    <li>
			      <a href="javascript:turnPage('{$page.pageNo}',0);" aria-label="Next">
			        <span aria-hidden="true">&raquo;</span>
			      </a>
			    </li>
			    <li><a href="javascript:void(0);">共{$page.total}条数据</a></li>
			  </ul>
			</nav>
		</div>	
	</body>
</html>