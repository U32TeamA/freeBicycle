<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="http://localhost:8080/freeBicycle/Public/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href=http://localhost:8080/freeBicycle/Public/bootstrap/css/bootstrap-datetimepicker.min.css>
		<style>
			.table tr th{text-align:center;}
			#searchForm input{width:25%}
			#searchForm select{width:25%}
			#topbtn span{margin-right:5px;}
		</style>
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src=http://localhost:8080/freeBicycle/Public/bootstrap/js/bootstrap-datetimepicker.min.js></script>
		<script type="text/javascript" src=http://localhost:8080/freeBicycle/Public/bootstrap/js/locales/bootstrap-datetimepicker.zh-CN.js></script>
		<script type="text/javascript">
		//time
		$(function(){
			$("#sttime").datetimepicker({
				   format:'yyyy-mm-dd',
				        weekStart: 1,
				        todayBtn:  1,
						autoclose: 1,
						todayHighlight: 1,
						startView: 2,
						forceParse: 0,
				        showMeridian: 1
				    });
		});
		//type值为0，下一页，为-1，上一页，为正到指定页
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
			if( <?php echo ($page["total"]); ?> < 10 ){
				return;
			}
			location.href = "http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/story/pageNo/"+pageNo;
		}
		//搜索下拉
		$(function(){
			$("#stername option[value != 0]").remove();
			$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/activityTerrace",
			function(data){
				for(var i=0;i<data.length;i++){
					$("#stername").append('<option value="'+data[i]['ter_name']+'">'+data[i]['ter_name']+'</option>');
				}
			},"json");
		});
		//重置按钮事件 
		function clearBtn(){
			$("#sname").val(""); 
			$("#spri").val("");
			$("#stime").val("");
		}
		//修改增加活动
		function storyAddEdit(type){
			//填充下拉
			$("#tername option[value != 0]").remove();
			$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/activityTerrace",
			function(data){
				for(var i=0;i<data.length;i++){
					$("#tername").append('<option value="'+data[i]['ter_id']+'">'+data[i]['ter_name']+'</option>');
				}
			},"json");
			//
			if(type == 1){
				$("#sname").val("");
				$("#surl").val("");
				$("#stime").val("");
				$("#ctr").val("1");
				$(".modal").modal("toggle");
			}else{
				var num = $("input[name=num]:checked");
				if(num.length != 1){
					alert("请选择一行进行操作！");
					return;
				}
				$("#ctr").val("0");
				$("#st_id").val(num.val());
				
				//回填表单
				$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/storySearch",{
					"stid":num.val()
				},function(data){
					$("#stname").val(data[0]['st_name']);
					$("#sturl").val(data[0]['st_url']);
					$("#sttime").val(data[0]['st_time']);
				},"json");
				$(".modal").modal("toggle");
			}
		}
		//删除
		function storydelete(){
			var num = $("input[name=num]:checked");
			if(num.length != 1){
				alert("请选择一行进行操作！");
			}
			if(confirm("却认删除该列吗？")){
				$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/storyDelete",{
					"stid":num.val()
				},function(data){
					//window.loaction.href="http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/story";
				},"json");
			}else{
				alert("操作已经取消！");
				return;
			}
		}
		//验证
		function inblur(obj,reg){
			$(obj).parent().removeClass("has-success has-error");
			$(obj).parent().find("span").removeClass("glyphicon-remove glyphicon-remove");
			if(reg.test(obj.value)){
			$(obj).parent().addClass("has-success");
			$(obj).parent().find("span").addClass("glyphicon-ok").css("color","green").show();
			$(obj).tooltip("hide");
				return true;
			}else{
				$(obj).parent().find("span").addClass("glyphicon-remove").css("color","red").show();
				$(obj).tooltip("show");
				$(obj).parent().addClass("has-error");
					return false;
			}
		}
		$(function(){
			
			//$("#pageLeft").append("<li><a href='javascript:turnPage(<?php echo ($page["pageNo"]); ?>,1);'>1</a></li>");
		});
		</script>
	</head>
	<body>
		<div class="container">
			<div id="topbtn" class="btn-group" role="group" style="width:98%;margin:10px 10px 0 10px;">
    		  <button type="button" class="btn btn-default" onclick="storyAddEdit(1);"><span class="glyphicon glyphicon-plus"></span>新增</button>
    		  <button type="button" class="btn btn-default" onclick="storyAddEdit(0);"><span class="glyphicon glyphicon-edit"></span>操作</button>
    		  <button type="button" class="btn btn-default" onclick="storydelete();"><span class="glyphicon glyphicon-trash"></span>删除</button>
    		  <!-- 条件搜索 -->
	   		  <form id="searchForm" action="http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/story" method="post">
	   		  		<div class="input-group">
		   		  		<input type="text" class="form-control" id="sname" name="sname" value="<?php echo ($page["sname"]); ?>" placeholder="故事标题关键字">
				      	<input type="text" class="form-control" id="surl" name="surl" value="<?php echo ($page["surl"]); ?>" placeholder="链接关键字">
				      	<input type="text" class="form-control" id="stime" name="stime" value="<?php echo ($page["stime"]); ?>" placeholder="发布时间">
				      	<select id="stername" name="stername" class="form-control">
							<option value="0">请选择发布平台</option>
						</select>
				      	<span class="input-group-btn">
				        	<button class="btn btn-default" type="submit">搜索</button>
				        	<button class="btn btn-default" id="resetBtn" onclick="clearBtn();">清除</button>
				      	</span>
			    	</div>
	   		  </form>
	   		</div>
			<table class="table table-striped table-bordered table-condensed text-center table-hover" style="width:98%;margin:10px 10px 0 10px;">
				<tr><th><input type="checkbox" name=nums id=nums></th><th>故事主题</th><th>故事链接</th><th>发布时间</th><th>发布平台</th></tr>
				<?php if(is_array($page["rows"])): $i = 0; $__LIST__ = $page["rows"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rows): $mod = ($i % 2 );++$i;?><tr>
						<td><input type="checkbox" name=num id=num value="<?php echo ($rows["st_id"]); ?>"></td>
						<td><?php echo ($rows["st_name"]); ?></td>
						<td><?php echo ($rows["st_url"]); ?></td>
						<td><?php echo ($rows["st_time"]); ?></td>
						<td><?php echo ($rows["ter_name"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
			<!-- 分页 -->
			<nav aria-label="Page navigation" class="text-center">
			  <ul class="pagination">
			  	<li><a href="javascript:void(0);">第<?php echo ($page["pageNo"]); ?>页</a></li>
			    <li id="pageLeft">
			      <a href="javascript:turnPage('<?php echo ($page["pageNo"]); ?>',-1);" aria-label="Previous">
			        <span aria-hidden="true">&laquo;</span>
			      </a>
			    </li>
			    <li><a href="javascript:turnPage('<?php echo ($page["pageNo"]); ?>',1);">1</a></li>
			    <li><a href="javascript:turnPage('<?php echo ($page["pageNo"]); ?>',2);">2</a></li>
			    <li><a href="javascript:turnPage('<?php echo ($page["pageNo"]); ?>',3);">3</a></li>
			    <li><a href="javascript:turnPage('<?php echo ($page["pageNo"]); ?>',4);">4</a></li>
			    <li><a href="javascript:turnPage('<?php echo ($page["pageNo"]); ?>',5);">5</a></li>
			    <li>
			      <a href="javascript:turnPage('<?php echo ($page["pageNo"]); ?>',0);" aria-label="Next">
			        <span aria-hidden="true">&raquo;</span>
			      </a>
			    </li>
			    <li><a href="javascript:void(0);">共<?php echo ($page["total"]); ?>条数据</a></li>
			  </ul>
			</nav>
		</div>
		<!-- 模态框 -->
		<div class="modal fade" tabindex="-1" role="dialog" id="addandedit">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">增加/修改故事</h4>
		      </div>
		      <div class="modal-body">
		      	<form action="http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/storyListEdit" method="post" class="text-center" enctype="multipart/form-data">
		        	<input type="hidden" name="ctr" id="ctr"/>
		        	<input type="hidden" name="st_id" id="st_id"/>
		        	<div class="form-group form-inline">
						<div class="input-group ">
							<div class="input-group-addon">故事主题</div>
							<input id="stname" name="stname" type="text" class="form-control" onblur="inblur(this,/([^\s])/)"/>
							<span class="glyphicon form-control-feedback"></span>
						</div>
					</div>
					<div class="form-group form-inline">
						<div class="input-group ">
							<div class="input-group-addon">故事链接</div>
							<input id="sturl" name="sturl" type="text" class="form-control" placeholder="url" onblur="inblur(this,/([^\s])/)"/>
							<span class="glyphicon form-control-feedback"></span>
						</div>
					</div>
					<div class="form-group form-inline">
						<div class="input-group ">
							<div class="input-group-addon">发布时间</div>
							<input id="sttime" name="sttime" type="text" class="form-control input-append date" readonly/>
							<span class="glyphicon form-control-feedback"></span>
						</div>
					</div>
		        	<div class="form-group form-inline">
						<div class="input-group">
							<div class="input-group-addon">发布平台</div>
							<select id="tername" name="tername" class="form-control" style="width:170px">
								<option value="0">请选择发布平台</option>
							</select>
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