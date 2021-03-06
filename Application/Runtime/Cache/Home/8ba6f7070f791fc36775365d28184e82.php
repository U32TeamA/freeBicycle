<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title>用户押金信息列表</title>
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
			location.href = "http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadPledgeList/pageNo/"+pageNo;
		}	
		//EXCEL导出
		function downExcel(){
			$.post("http://localhost:8080/freeBicycle/index.php/Home/ZJExcelDownLoad/excelDownLoad",
			{
				"table"        : "tb_pledge pl,tb_user u",
				"where"        : "pl.u_id=u.u_id",
				"field"		   : "pl.pl_no,u.u_account,pl.pl_money,pl.pl_time",
				"tableHeader"  : ['押金编号','用户帐号','押金金额','押金时间']
			},function(data){
				location.href = "http://localhost:8080/freeBicycle/index.php?m=Home&c=ZJExcelDownLoad&a=down&name=用户押金信息表.xls&load=Public/tmpFiles/new.xls" ;
			});
		}
		//打开模态框
		function openWin(){			
			//判断是否选择一行数据进行操作
			var ids = $("input[type=checkbox]:checked");
			//alert(ids.length);
			if(ids.length > 1){
				alert("只能选择一行数据！");
				return;
			}
			if(ids.length == 0){
				alert("请选择一行数据！");
				return;
			}
			var pl_id = ids.val();
			//alert(pl_id);
			//编辑时打开窗口，表单回填
			$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadPledgeById",{pl_id:pl_id},function(data){
				//alert(JSON.stringify(data))
				$("#pl_no").val(data.pl_no);
				$("#u_account").val(data.u_account);
				$("#pl_money").val(data.pl_money);	
				if(data.pl_money == 0){
					alert("该用户押金已退还");
					$("#myModal").modal("hide");
				}else{
					$("#myModal").modal("show");
				}
			},"json");			
		}	
		//点击td选择多选按钮
		function checkedThis(obj){
			//这是通过函数来设置所有页面上的复选框被选中
			if($(obj).find("input").prop("checked")){
				$(obj).find("input").prop("checked",false);
			}else{
				$(obj).find("input").prop("checked","checked");
			}
		}
		//全选
		function chooseALL(){
			$("#choose input").prop("checked",true);		
		}
		//批量退还押金
		function openWin2(){
			if($("#choose input").prop("checked")){
				//获取复选框选中的多个值
				var pl_ids = [];
				$("#choose input:checked").each(function(){
					pl_ids.push($(this).val());
				});
				//alert(checks);
				$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadPledgeByIds",{pl_ids:pl_ids},function(data){
					//alert(JSON.stringify(data))
					$("#u_account").val(data.u_account);
				},"josn");
				$("#myModal2").modal("show");
			}else{
				alert("请先全选数据");
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
   		  	<button type="button" class="btn btn-default" style="margin-top:0.8%;margin-left:0.1%;" onclick="openWin();">
   		  		<span class="glyphicon glyphicon-edit"></span>押金退还
   		  	</button>
   		  	<button type="button" class="btn btn-default" style="margin-top:0.8%;margin-left:0.1%;" onclick="openWin2();">
   		  		<span class="glyphicon glyphicon-folder-open"></span>批量退还
   		  	</button>
   		  	<a href="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/PledgeBackInfo" type="button" class="btn btn-default" style="margin-top:0.8%;margin-left:0.1%;">
   		  		<span class="glyphicon glyphicon-share-alt"></span>查看退还记录
   		  	</a>
   		  	<!-- 模态窗1 -->
			<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
			    <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">押金退还</h4>
				      </div>
				      <div class="modal-body">
				      	  <form id="ff" action="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/editPledgeBack" method="post">
							<div class="form-group">
								<label>押金编号：</label>
								<input type="text" class="form-control" id="pl_no" name="pl_no" readonly>
							</div>
							<div class="form-group">
								<label>用户帐号：</label>
								<input type="text" class="form-control" id="u_account" name="u_account" readonly>				
							</div>
							<div class="form-group">
								<label>退还押金金额：</label>
								<input type="text" class="form-control" id="pl_money" name="pl_money" readonly>
							</div>
							<div class="form-group">
								<label>是否退还：</label>
								<select style="width:100%;height:30px;" name="pl_back">
									<option value="0">否</option>
									<option value="1" selected>是</option>
								</select>
							</div>					
				      	    <div class="modal-footer">
						        <button type="reset" class="btn btn-default">取消</button>
						        <button type="submit" class="btn btn-primary">确认</button>
					        </div>
					      </form>
				      </div>			      
				    </div>
			    </div>
			</div>
			<!-- 模态窗2 -->
			<div class="modal fade" tabindex="-1" role="dialog" id="myModal2">
			    <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">批量退还</h4>
				      </div>
				      <div class="modal-body">
				      	  <form id="ff" action="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/saveAllPledge" method="post">
							<input type="hidden" name="plid" id="plid"/>
							<div class="form-group">
								<label>用户帐号：</label>
								<input type="text" class="form-control" id="u_account" name="u_account" readonly>				
							</div>
							<div class="form-group">
								<label>是否退还押金：</label>
								<select style="width:100%;height:30px;" name="pl_back">
									<option value="0">否</option>
									<option value="1" selected>是</option>
								</select>
							</div>					
				      	    <div class="modal-footer">
						        <button type="reset" class="btn btn-default">取消</button>
						        <button type="submit" class="btn btn-primary">确认</button>
					        </div>
					      </form>
				      </div>			      
				    </div>
			    </div>
			</div>
   		  	<!-- 条件搜索 -->
   		  	<form id="searchForm" action="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/searchPledgeList" method="post"
   		  		  class="navbar-form navbar-right" role="search">
   		  		<div class="form-group form-inline">
	   		  		<input type="text" class="form-control" id="searchUser" name="searchUser" value="<?php echo ($page["searchUser"]); ?>" placeholder="输入用户帐号">
	   		  		<input type="text" class="form-control" id="searchNo" name="searchNo" value="<?php echo ($page["searchNo"]); ?>" placeholder="输入押金编号">		        	
		    	</div>
		    	<button class="btn btn-info" type="submit">搜索</button>
		    	<a href="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadPledgeList" class="btn btn-default" type="reset">重置</a>
   		  	</form>
   		</div>
   		<!-- 列表展示 -->
		<table class="table table-striped table-bordered table-condensed" style="width:98%;margin:10px 10px 0 10px;">
			<tr>
				<th style="width:10%"><input id="checks" type="checkbox" name="" onclick="chooseALL()" />全选当前数据</th>
				<th>押金编号</th>
				<th>用户帐号</th>
				<th>押金金额</th>
				<th>押金时间</th>			
			</tr>
			<?php if(is_array($page["rows"])): foreach($page["rows"] as $key=>$rows): ?><tr onclick="checkedThis(this)">
					<td id="choose"><input type="checkbox" name="ids" value="<?php echo ($rows["pl_id"]); ?>"/></td>
					<td><?php echo ($rows["pl_no"]); ?></td>
					<td style="color:green;"><?php echo ($rows["u_account"]); ?></td>
					<td style="color:blue;"><?php echo ($rows["pl_money"]); ?></td>
					<td><?php echo ($rows["pl_time"]); ?></td>
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