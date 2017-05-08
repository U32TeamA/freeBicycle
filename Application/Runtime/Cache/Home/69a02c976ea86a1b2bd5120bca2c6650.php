<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title>抽奖礼品信息列表</title>
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
			location.href = "http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadPrizeList/pageNo/"+pageNo;
		}
		//打开模态框
		function openWin(){
			$("#myModal").modal("show");
		}
		//文件上传功能判断
		$(function() {
			//上传文件程序
			$("#btn1").click(function() {
				$("#file").click();
			});
			$("#file").change(function() {
				var files = $('#file')[0].files; // 获取所有的文件类型
				//files为文件对象数组 
				var fileType = "image/png,image/jpg,image/gif,image/jpeg";
				//判断上传的文件是否是图片文件；
				if(fileType.indexOf(files[0].type) >= 0) {
					$("#fileName").val(files[0].name);
				} else {
					$("#fileName").val();
					alert("输入错误！请选择png,jpg,gif格式的图片！");
				}
			});
		})
		// bootstrap表单验证
		function onb(obj, regExp) {
			$(obj).parent().removeClass("has-success has-error");
			if(regExp.test(obj.value)) {				
	     		$(obj).parent().addClass("has-success");
				return true;	
			} else {
				$(obj).parent().addClass("has-error");
				return false;
			}	
		}
		//二次验证
		function check() {
			var name = onb($("#prizeName")[0],  /[\u4E00-\u9FA5\uF900-\uFA2D]/);
			var inte = onb($("#integral")[0], /^\+?[1-9][0-9]*$/);
			var cost = onb($("#cost")[0], /^\+?[1-9][0-9]*$/);
			if(name && inte && cost) {
				return true;
			} else {
				return false;
			}
		}
		</script>
	</head>
	<body>
	<div class="container">
		<div id="topbtn" class="btn-group" role="group" style="width:98%;margin:10px 10px 0 10px;">
   		  	<button type="button" class="btn btn-default" style="margin-top:0.8%;" onclick="openWin();">
   		  		<span class="glyphicon glyphicon-gift"></span>添加奖品
   		  	</button>
   		  	<button type="button" class="btn btn-default" style="margin-top:0.8%;">
   		  		<span class="glyphicon glyphicon-file"></span>导出Excel
   		  	</button>
   		  	<!-- 模态窗 -->
			<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
			    <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">新增奖品</h4>
				      </div>
				      <div class="modal-body">
				      	  <form id="ff" action="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/addPrizeInfo" method="post">
							<div class="form-group">
								<label>奖品名称：</label>
								<input type="text" class="form-control" id="prizeName" name="prizeName" placeholder="输入奖品名称" onblur="onb(this, /[\u4E00-\u9FA5\uF900-\uFA2D]/)">
							</div>
							<div class="form-group">
								<label>奖品图片：</label>
								<input id="file" name="picture" type="file" style="display: none;"/>
								<input id="fileName" type="text" placeholder="上传图片 " class="form-control" style="width: 70%;" readonly/>
								<span id="btn1" class="btn btn-success" style="width: 29%;margin-left:70%;margin-top:-10%;">点击上传</span>						
							</div>
							<div class="form-group">
								<label>奖品所需积分：</label>
								<input type="text" class="form-control" id="integral" name="integral" placeholder="输入奖品所需积分" onblur="onb(this,/^\+?[1-9][0-9]*$/)">
							</div>
							<div class="form-group">
								<label>奖品成本：</label>
								<input type="text" class="form-control" id="cost" name="cost" placeholder="输入奖品成本金额" onblur="onb(this,/^\+?[1-9][0-9]*$/)">
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
   		  	<form id="searchForm" action="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/searchPrizeList" method="post"
   		  		  class="navbar-form navbar-right" role="search">
   		  		<div class="form-group form-inline">
	   		  		<input type="text" class="form-control" id="searchName" name="searchName" value="<?php echo ($page["searchName"]); ?>" placeholder="输入奖品名称">		        	
		    	</div>
		    	<button class="btn btn-info" type="submit">搜索</button>
		    	<a href="http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadPrizeList" class="btn btn-default" type="reset">重置</a>
   		  	</form>
   		</div>
   		<!-- 列表展示 -->
		<table class="table table-striped table-bordered table-condensed" style="width:98%;margin:10px 10px 0 10px;">
			<tr>
				<th>奖品编号</th>
				<th>奖品名称</th>
				<th>奖品图片</th>
				<th>奖品所需积分</th>
				<th>奖品成本(单位：元)</th>
			</tr>
			<?php if(is_array($page["rows"])): foreach($page["rows"] as $key=>$rows): ?><tr>
					<td><?php echo ($rows["pr_id"]); ?></td>
					<td style="color:red;"><?php echo ($rows["pr_name"]); ?></td>
					<td><?php echo ($rows["pr_picture"]); ?></td>
					<td style="color:red;"><?php echo ($rows["pr_integral"]); ?></td>
					<td><?php echo ($rows["pr_cost"]); ?></td>
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