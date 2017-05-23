<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>低频单车信息列表</title>
		<link rel="stylesheet" href="http://localhost:8080/freeBicycle/Public/bootstrap/css/bootstrap.min.css"/>
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/bootstrap/js/bootstrap.min.js"></script>
		<style type="text/css">
		tr th{text-align:center;}
		tr td{text-align:center;}
		</style>
		<script type="text/javascript">
		//type = 0 表示翻下一页， 等于 -1表示翻上一页 ， 大于0表示翻到指定页
		function turnPage(pageNo,type){
			//强制转换，把字符串转换为整数
			var pageNo = parseInt(pageNo);
			if(type == 0){
				pageNo = pageNo+1;
				//判断是否是最后页了
				if(pageNo > parseInt('<?php echo ($page["total"]); ?>'/10)+1){
					alert("该页已经是最后一页了");
					pageNo = parseInt('<?php echo ($page["total"]); ?>'/10)+1;
				}
			}else if(type == -1){
				pageNo = pageNo-1;
				//判断是否为第一页
				if(pageNo == 0){
					alert("当前已经是第一页了");
					return;
				}
			}else{
				pageNo = type;
			}
			location.href = "http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadLowsBicycle?pageNo="+pageNo;
		}
		//搜索重置
		function uset(){
			$("#searchNo").val("");
			$("#searchModel").val("");
		}
		//EXCEL导出
		function downExcel(){
			$.post("http://localhost:8080/freeBicycle/index.php/Home/ExcelDownLoadZhang/excelDownLoad",
			{
				"table"			:	"tb_bicycle bc",
				"join"			:	"join tb_bicycle_state bcs on bcs.bs_id=bc.bs_id join tb_terrace ter on ter.ter_id=bc.ter_id",
				"where"			:	"bc.bs_id=1",
				"field"			:	"bc.bi_no,bc.bi_model,bcs.bs_name,ter.ter_name,bc.bi_putTime",
				"tableHeader"   :   ['单车编号','单车型号','单车状态','所属平台','单车投放时间']
			},function(data){
				location.href = "http://localhost:8080/freeBicycle/index.php?m=Home&c=ExcelDownLoadZhang&a=down&name=低频单车信息表.xls&load=Public/tmpFiles/new.xls" ;
			});
		}
		</script>
	</head>
	<body>
		<div class="container">
			<div id="topbtn" class="btn-group" role="group" style="width:98%;margin:10px 10px 0 10px;">
				<button type="button" class="btn btn-default" style="margin-top:0.8%;" onclick="downExcel()">
	   		  		<span class="glyphicon glyphicon-file"></span>导出Excel
	   		  	</button>
	   		  	<!-- 条件搜索 -->
	   		  	<form id="searchForm" action="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadLowsBicycle" method="post"
	   		  		  class="navbar-form navbar-right" role="search">
	   		  		<div class="form-group form-inline">
		   		  		<input type="text" class="form-control" id="searchNo" name="searchNo" value="<?php echo ($page["searchNo"]); ?>" placeholder="输入单车编号">
		   		  		<input type="text" class="form-control" id="searchModel" name="searchModel" value="<?php echo ($page["searchModel"]); ?>" placeholder="输入单车型号">		        	
			    	</div>
			    	<button class="btn btn-info" type="submit">搜索</button>
			    	<button class="btn btn-default" onclick="uset()">重置</button>
	   		  	</form>
			</div>
			<!-- 列表展示  -->
			<table class="table table-striped table-bordered table-condensed" style="width:98%;margin:10px 10px 0 10px;">
				<tr>
					<th>单车编号</th>
					<th>单车型号</th>
					<th>单车状态</th>
					<th>所属平台</th>
					<th>单车投放时间</th>
				</tr>
				<?php if(is_array($page["rows"])): foreach($page["rows"] as $key=>$rows): ?><tr>
						<td><?php echo ($rows["bi_no"]); ?></td>
						<td><?php echo ($rows["bi_model"]); ?></td>
						<td style="color:red;"><?php echo ($rows["bs_name"]); ?></td>
						<td><?php echo ($rows["ter_name"]); ?></td>
						<td><?php echo ($rows["bi_puttime"]); ?></td>
					</tr><?php endforeach; endif; ?>
			</table>
			<!-- 翻页控件 -->
			<nav aria-label="Page navigation" class="text-center">
			    <ul class="pagination">
			  		<li><a href="javascript:void(0);">第<?php echo ($page["pageNo"]); ?>页</a></li>
				    <li>
				        <a href="javascript:turnPage(<?php echo ($page["pageNo"]); ?>,-1);" aria-label="Previous">
				            <span aria-hidden="true">&laquo;</span>
				        </a>
				    </li>
				    <li><a href="javascript:turnPage(<?php echo ($page["pageNo"]); ?>,1);">1</a></li>
				    <li><a href="javascript:turnPage(<?php echo ($page["pageNo"]); ?>,2);">2</a></li>
				    <li><a href="javascript:turnPage(<?php echo ($page["pageNo"]); ?>,3);">3</a></li>
				    <li><a href="javascript:turnPage(<?php echo ($page["pageNo"]); ?>,4);">4</a></li>
				    <li><a href="javascript:turnPage(<?php echo ($page["pageNo"]); ?>,5);">5</a></li>
				    <li>
				        <a href="javascript:turnPage(<?php echo ($page["pageNo"]); ?>,0);" aria-label="Next">
				        	<span aria-hidden="true">&raquo;</span>
				        </a>
				    </li>
				    <li><a href="javascript:void(0);">共<?php echo ($page["total"]); ?>条数据</a></li>
			    </ul>
			</nav>
		</div>
	</body>
</html>