<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title>单车平台信息列表</title>
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
			location.href = "http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadTerraceList/pageNo/"+pageNo;
		}	
		//页面加载时回填平台名称
		$(function(){
			//先清除value不等于-1的option
			$("#tername option[value != 选择单车平台]").remove();
			//异步加载数据并回填
			$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadBicycleTerrace",function(data){
				//alert(data.length);
				for(i=0;i<data.length;i++){
					$("#tername").append("<option value='"+data[i]['ter_name']+"'>"+data[i]['ter_name']+"</option>");
				}		
			},"json");
		});
		//重置按钮
		function uset(){
			$("#user").val("");
			$("#tername").val("");
		}
		</script>
	</head>
	<body>
	<div class="container">
		<div id="topbtn" class="btn-group" role="group" style="width:98%;margin:10px 10px 0 10px;">
   		  	<a href="http://localhost:8080/freeBicycle/Application/Home/View/ZJ/addTerraceInfo.html" type="button" class="btn btn-default" style="margin-top:0.8%;">
   		  		<span class="glyphicon glyphicon-plus"></span>添加平台
   		  	</a>
   		  	<!-- 条件搜索 -->
   		  	<form id="searchForm" action="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadTerraceList" method="post"
   		  		  class="navbar-form navbar-right" role="search">
   		  		<div class="form-group form-inline">
	   		  		<select name="tername" id="tername" class="form-control">
	   		  			<option value="选择单车平台">选择单车平台</option>
	   		  			<option><?php echo ($page["tername"]); ?></option>
	   		  		</select>
	   		  		<input type="text" class="form-control" id="user" name="user" value="<?php echo ($page["user"]); ?>" placeholder="平台联系人姓名">		        	
		    	</div>
		    	<button class="btn btn-info" type="submit">搜索</button>
		    	<button class="btn btn-default" onclick="uset()">重置</button>
   		  	</form>
   		</div>
		<table class="table table-striped table-bordered table-condensed" style="width:98%;margin:10px 10px 0 10px;">
			<tr>
				<th>平台编号</th>
				<th>平台名称</th>
				<th>平台地址</th>
				<th>平台联系人</th>
				<th>平台联系电话</th>
			</tr>
			<?php if(is_array($page["rows"])): foreach($page["rows"] as $key=>$rows): ?><tr>
					<td><?php echo ($rows["ter_id"]); ?></td>
					<td><?php echo ($rows["ter_name"]); ?></td>
					<td><?php echo ($rows["ter_address"]); ?></td>
					<td style="color:red;"><?php echo ($rows["ter_person"]); ?></td>
					<td><?php echo ($rows["ter_phone"]); ?></td>
				</tr><?php endforeach; endif; ?>
		</table>
		<!-- 翻页按钮 -->
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