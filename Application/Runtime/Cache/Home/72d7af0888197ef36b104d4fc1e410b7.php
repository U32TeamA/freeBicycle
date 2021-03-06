<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title>消失单车信息列表</title>
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
			location.href = "http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/bicycleDisappearList/pageNo/"+pageNo;
		}	
		//EXCEL导出
		function downExcel(){
			$.post("http://localhost:8080/freeBicycle/index.php/Home/ExcelDownLoadZhang/excelDownLoad",
			{
				"table"        : "tb_bicycle bc",
				"join"         : "join tb_bicycle_state bcs on bcs.bs_id=bc.bs_id join tb_terrace ter on ter.ter_id=bc.ter_id",
				"where"		   : "bc.bs_id=5",
				"field"		   : "bc.bi_no,bc.bi_model,bcs.bs_name,ter.ter_name,bc.bi_putTime",
				"tableHeader"  : ['单车编号','单车型号','单车状态','所属平台','单车投放时间']
			},function(data){
				location.href = "http://localhost:8080/freeBicycle/index.php?m=Home&c=ExcelDownLoadZhang&a=down&name=单车消失信息表.xls&load=Public/tmpFiles/new.xls" ;
			});
		}
		//重置按钮
		function uset(){
			$("#searchNo").val("");
			$("#searchModel").val("");
		}
		//打开模态窗口
		function openWin(){
			var nos = $("input[name=nos]:checked");
			if(nos.length == 1){
				var num = nos.eq(0).val();
				$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadBicycleDisappear",{bi_no:num},function(data){
					$("#bi_no").val(data[0]['bi_no']);
					$("#bi_model").val(data[0]['bi_model']);
					$("#bi_journey").val(data[0]['bi_journey']);
					$("#bs_name").val(data[0]['bs_name']);
					$("#ter_name").val(data[0]['ter_name']);
					$("#bi_putTime").val(data[0]['bi_puttime']);
					$("#bi_NumOfUse").val(data[0]['bi_numofuse']);
				},"json");
				$("#myModal").modal("show");
			}else if(nos.length > 1){
				alert("只能选择一行数据！");
			}else{
				alert("请选择一行数据");
			}		
		}
		//删除某一行数据（软删除即只是修改某一列的值）
		function delet(){
			var nos = $("input[name=nos]:checked");
			if(nos.length == 1){
				var num = nos.eq(0).val();
				if(confirm("确认删除此行信息吗？")){
					$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/deleteDisappearBicycle",{bi_no:num},function(data){
						
					},"json");
				}else{
					alert("我再考虑考虑！");
				}
			}else if(nos.length > 1){
				alert("只能选择一行数据！");
			}else{
				alert("请选择一行数据");
			}	
		}
		</script>
	</head>
	<body>
	<div class="container">
		<div id="topbtn" class="btn-group" role="group" style="width:98%;margin:10px 10px 0 10px;">   		  	
   		  	<button type="button" class="btn btn-default" style="margin-top:0.8%;" onclick="downExcel()">
   		  		<span class="glyphicon glyphicon-file"></span>导出Excel
   		  	</button>
   		  	<button type="button" class="btn btn-default" style="margin-top:0.8%;margin-left:0.1%" onclick="openWin()">
   		  		<span class="glyphicon glyphicon-hand-right"></span>查看详情
   		  	</button>
   		  	<button type="button" class="btn btn-default" style="margin:0.8%;margin-left:0.1%" onclick="delet()">
   		  		<span class="glyphicon glyphicon-remove"></span>删除消失单车
   		  	</button>
   		  	<!-- 模态框 -->
			<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
			  	<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        		<h4 class="modal-title">单车消失详情</h4>
			      		</div>
			      		<div class="modal-body">
					      	<form class="text-center" enctype="multipart/form-data">
					        	<div class="form-group form-inline">
									<div class="input-group ">
										<div class="input-group-addon">单车编号</div>
										<input id="bi_no" name="bi_no" type="text" class="form-control" readonly/>
									</div>
								</div>
								<div class="form-group form-inline">
									<div class="input-group ">
										<div class="input-group-addon">单车型号</div>
										<input id="bi_model" name="bi_model" type="text" class="form-control" readonly/>
									</div>
								</div>
								<div class="form-group form-inline">
									<div class="input-group ">
										<div class="input-group-addon">单车行程</div>
										<input id="bi_journey" name="bi_journey" type="text" class="form-control" readonly/>
									</div>
								</div>
					        	<div class="form-group form-inline">
									<div class="input-group">
										<div class="input-group-addon">单车状态</div>
										<input type="text" class="form-control" id="bs_name" name="bs_name" style="color:red;" readonly/>
									</div>
								</div>
								<div class="form-group form-inline">
									<div class="input-group">
										<div class="input-group-addon">所属平台</div>
										<input type="text" id="ter_name" name="ter_name" class="form-control" readonly/>														
									</div>
								</div>
								<div class="form-group form-inline">
									<div class="input-group">
										<div class="input-group-addon">投放时间</div>
										<input type="text" id="bi_putTime" name="bi_putTime" class="form-control" readonly/>
									</div>
								</div>
								<div class="form-group form-inline">
									<div class="input-group">
										<div class="input-group-addon">使用次数</div>
										<input type="text" id="bi_NumOfUse" name="bi_NumOfUse" class="form-control" readonly/>
									</div>
								</div>
					        </form>
					    </div>
			        </div>
			     </div>
			</div>
   		  	<!-- 条件搜索 -->
   		  	<form id="searchForm" action="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/bicycleDisappearList" method="post"
   		  		  class="navbar-form navbar-right" role="search">
   		  		<div class="form-group form-inline">
	   		  		<input type="text" class="form-control" id="searchNo" name="searchNo" value="<?php echo ($page["searchNo"]); ?>" placeholder="输入单车编号">
	   		  		<input type="text" class="form-control" id="searchModel" name="searchModel" value="<?php echo ($page["searchModel"]); ?>" placeholder="输入单车型号">		        	
		    	</div>
		    	<button class="btn btn-info" type="submit">搜索</button>
		    	<button class="btn btn-default" onclick="uset()">重置</button>
   		  	</form>
   		</div>
   		<!-- 列表展示 -->
		<table class="table table-striped table-bordered table-condensed" style="width:98%;margin:10px 10px 0 10px;">
			<tr>
				<th><input type="checkbox" name=""/></th>
				<th>单车编号</th>
				<th>单车型号</th>
				<th>单车状态</th>
				<th>所属平台</th>
				<th>单车投放时间</th>			
			</tr>
			<?php if(is_array($page["rows"])): foreach($page["rows"] as $key=>$rows): ?><tr>
					<td><input type="checkbox" id="nos" name="nos" value="<?php echo ($rows["bi_no"]); ?>"/></td>
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