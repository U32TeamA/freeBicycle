<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title>中奖人员信息列表</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="http://localhost:8080/freeBicycle/Public/bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/bootstrap/js/bootstrap.min.js"></script>
		<style type="text/css">
			tr{text-align:center;}
			tr th{text-align:center;}
        </style>
		<script type="text/javascript">
		//type值为0表下一页，为-1表上一页，为正到指定页
		function turnPage(pageNo,type){
			var pageNo = parseInt(pageNo);
			if(type == 0){
				pageNo += 1;
				if(pageNo > parseInt('<?php echo ($page["total"]); ?>'/10)+1){
					alert('已经是最后一页了！');
					pageNo = parseInt('<?php echo ($page["total"]); ?>'/10)+1;
				}
			}else if(type == -1){
				pageNo -= 1;
				if(pageNo == 0){
					alert('已经是第一页了！');
					pageNo = 1;
				}
			}else{
				pageNo = type;
			}
			location.href = "http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadWinnersList/pageNo/"+pageNo;
		}	
		//EXCEL导出
		function downExcel(){
			$.post("http://localhost:8080/freeBicycle/index.php/Home/ExcelDownLoadZJ/excelDownLoad",
			{
				"table"        : "tb_win w",
				"join"         : "join tb_user u on u.u_id=w.u_id join tb_prize pr on pr.pr_id=w.pr_id",
				"field"		   : "w.wi_id,u.u_account,pr.pr_name,w.wi_time",
				"tableHeader"  : ['编号','用户帐号','奖品名称','中奖时间']
			},function(data){
				location.href = "http://localhost:8080/freeBicycle/index.php?m=Home&c=ExcelDownLoadZJ&a=down&name=中奖信息表.xls&load=Public/tmpFiles/new.xls" ;
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
   		  	<form id="searchForm" action="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/searchWinnersList" method="post"
   		  		  class="navbar-form navbar-right" role="search">
   		  		<div class="form-group form-inline">
	   		  		<input type="text" class="form-control" id="searchUser" name="searchUser" value="<?php echo ($page["searchUser"]); ?>" placeholder="输入用户帐号">
	   		  		<input type="text" class="form-control" id="searchName" name="searchName" value="<?php echo ($page["searchName"]); ?>" placeholder="输入奖品名称">		        	
		    	</div>
		    	<button class="btn btn-info" type="submit">搜索</button>
		    	<a href="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadWinnersList" class="btn btn-default" type="reset">重置</a>
   		  	</form>
   		</div>
   		<!-- 列表展示 -->
		<table class="table table-striped table-bordered table-condensed" style="width:98%;margin:10px 10px 0 10px;">
			<tr>
				<th>编号</th>
				<th>用户帐号</th>
				<th>奖品名称</th>
				<th>中奖时间</th>			
			</tr>
			<?php if(is_array($page["rows"])): foreach($page["rows"] as $key=>$rows): ?><tr>
					<td><?php echo ($rows["wi_id"]); ?></td>
					<td style="color:red;"><?php echo ($rows["u_account"]); ?></td>
					<td style="color:orange;"><?php echo ($rows["pr_name"]); ?></td>
					<td><?php echo ($rows["wi_time"]); ?></td>
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