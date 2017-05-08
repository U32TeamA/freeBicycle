<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="http://localhost:8080/freeBicycle/Public/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href=http://localhost:8080/freeBicycle/Public/bootstrap/css/bootstrap-datetimepicker.min.css>
		<style>
			#topbtn span{margin-right:5px;}
            .search{height:33px;margin-left:10px;padding:0;}
			#searchForm input{width:25%;}
			#searchForm select{width:25%;}
			.table tr th{text-align:center;}
			.table{width:98%;margin:10px 10px 0 10px;}
		</style>
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src=http://localhost:8080/freeBicycle/Public/bootstrap/js/bootstrap-datetimepicker.min.js></script>
		<script type="text/javascript" src=http://localhost:8080/freeBicycle/Public/bootstrap/js/locales/bootstrap-datetimepicker.zh-CN.js></script>
		<script type="text/javascript">
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
				location.href = "http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/activity/pageNo/"+pageNo;
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
				//平台列表
				$("#stername option[value != '']").remove();
				$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/activityTerrace"	
				,function(data){
					for(var i=1;i<data.length;i++){
						$("#stername").append("<option value='"+data[i]['ter_id']+"'>"+data[i]['ter_name']+"</option>");
					}
				},"json");
			});
			//判断传入的值选择增加或者修改
			function addedit(type){
				//平台列表
				$("#tername option[value != -1]").remove();
				$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/activityTerrace"	
				,function(data){
					for(var i=1;i<data.length;i++){
						$("#tername").append("<option value='"+data[i]['ter_id']+"'>"+data[i]['ter_name']+"</option>");
					}
				},"json");
				//
				if(type == 1){
					$("#ctr").val("1");
					$("#addandedit").modal("toggle");
				}else{
					var num = $("input[name=num]:checked");
					if(num.length != 1){
						alert("请选择一项进行操作！");
						return;
					}
					$("#ctr").val("0");
					$("#ac_id").val(num.val());
					//回填
					$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/activitySearch",{
						"acid":num.val()
					},function(data){
						$("#acname").val(data[0]['ac_name']);
						$("#acurl").val(data[0]['ac_url']);
						$("#issuetime").val(data[0]['ac_time']);
					},"json");
					$("#addandedit").modal("toggle");	
				}
			}
			//删除活动
	 		function hide(){
	 			var num = $("input[name=num]:checked");
				if(num.length != 1){
					alert("请选择一项进行操作！");
					return;
				}
				if(confirm('确认删除该条吗？')){
					$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/activityListHide",{
						"acid":num.val()	
					},function(data){
							
					},"json");
				}else{
					alert('操作已经取消！');
					return;
				}
	 		}
			//跳到中奖表
			function turnwin(){
				alert('中奖！');
			}
			//time
			$(function(){
				$("#issuetime").datetimepicker({
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
			
			//复制
			
			
			//function copyurl(){
			//	var num = $("input[name=num]:checked");
			//	if(num.length != 1){
			//		alert("请选择一项进行操作！");
			//		return;
				//}
				//$('#copyurlbtn').zclip({   
			  //      path: 'ZeroClipboard.swf',   
			  //      copy: function(){
			   //         return num.next(".myurl").text();
			    //    	alert(num.next(".myurl").text());
			    //    },   
			    //    afterCopy: function(){
			    //    	alert('复制成功！');
			    //    //    $("<span id='msg'/>").insertAfter($('#copyurlbtn')).text('复制成功!');   
			   //     }   
			   // }); 
			//}
		</script>
	</head>
	<body>
		<div class="container">
			<div id="topbtn" class="btn-group" role="group" style="width:98%;margin:10px 10px 0 10px;">
    		  <button type="button" class="btn btn-default" onclick="addedit(1);"><span class="glyphicon glyphicon-plus"></span>新增</button>
    		  <button type="button" class="btn btn-default" onclick="addedit(0);"><span class="glyphicon glyphicon-edit"></span>操作</button>
    		  <button type="button" class="btn btn-default" onclick="hide();"><span class="glyphicon glyphicon-trash"></span>删除</button>
    		  <button type="button" class="btn btn-default" onclick="turnwin();"><span class="glyphicon glyphicon-user"></span>中奖名单</button>
    		  <button type="button" class="btn btn-default" id="copyurlbtn" oncilck="copyurl()"><span class="glyphicon glyphicon-copy"></span>复制选中的链接</button>
    		  <!-- 条件搜索 -->
	   		  <form id="searchForm" action="http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/activity" method="post">
	   		  		<div class="input-group">
		   		  		<input type="text" class="form-control" id="sname" name="sname" value="<?php echo ($page["sname"]); ?>" placeholder="主题关键字">
				      	<input type="text" class="form-control" id="surl" name="surl" value="<?php echo ($page["surl"]); ?>" placeholder="地址关键字">
				      	<input type="text" class="form-control" id="stime" name="stime" value="<?php echo ($page["stime"]); ?>" placeholder="发布时间">
				      	<select id="stername" name="stername" class="form-control">
							<option value="">请选择活动平台</option>
						</select>
				      	<span class="input-group-btn">
				        	<button class="btn btn-default" type="submit">搜索</button>
				      	</span>
			    	</div>
	   		  </form>
	   		</div>
			<table class="table table-striped table-bordered table-condensed text-center table-hover">
				<tr>
					<th><input type="checkbox" name="nums" id="nums"/></th><th>活动主题</th><th>活动链接</th><th>发布时间</th><th>活动平台</th>
				</tr>
				<?php if(is_array($page["rows"])): $i = 0; $__LIST__ = $page["rows"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rows): $mod = ($i % 2 );++$i;?><tr>
					<td><input type="checkbox" name="num" id="num" value="<?php echo ($rows["ac_id"]); ?>"/></td>
					<td><?php echo ($rows["ac_name"]); ?></td>
					<td class="myurl"><?php echo ($rows["ac_url"]); ?></td>
					<td><?php echo ($rows["ac_time"]); ?></td>
					<td><?php echo ($rows["tname"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
			<!-- 翻页按钮 -->
			<nav aria-label="Page navigation" class="text-center">
			  <ul class="pagination">
			  	<li><a href="javascript:void(0);">第<?php echo ($page["pageNo"]); ?>页</a></li>
			    <li>
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
		        <h4 class="modal-title">增加/修改</h4>
		      </div>
		      <div class="modal-body">
		      	<form action="http://localhost:8080/freeBicycle/index.php/Home/BicycleListYRB/activityListEdit" method="post" class="text-center">
		        	<input type="hidden" name="ctr" id="ctr"/>
		        	<input type="hidden" name="ac_id" id="ac_id"/>
		        	<div class="form-group form-inline">
						<div class="input-group ">
							<div class="input-group-addon">活动主题</div>
							<input id="acname" name="acname" type="text" class="form-control" onblur="inblur(this,/([^\s])/)"/>
							<span class="glyphicon form-control-feedback"></span>
						</div>
					</div>
					<div class="form-group form-inline">
						<div class="input-group ">
							<div class="input-group-addon">活动链接</div>
							<input id="acurl" name="acurl" type="text" class="form-control" onblur="inblur(this,/([^\s])/)"/>
							<span class="glyphicon form-control-feedback"></span>
						</div>
					</div>
					<div class="form-group form-inline">
						<div class="input-group ">
							<div class="input-group-addon">发布时间</div>
							<input id="issuetime" name="issuetime" type="text" class="form-control input-append date" readonly/>
							<span class="glyphicon form-control-feedback"></span>
						</div>
					</div>
		        	<div class="form-group form-inline">
						<div class="input-group">
							<div class="input-group-addon">活动平台</div>
							<select id="tername" name="tername" class="form-control" style="width:170px">
								<option value="-1">请选择活动平台</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
			        <button type="button" class="btn btn-default">取消</button>
			        <input type="submit" class="btn btn-primary" value="确认">
			      </div>
		        </form>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div>
	</body>
</html>