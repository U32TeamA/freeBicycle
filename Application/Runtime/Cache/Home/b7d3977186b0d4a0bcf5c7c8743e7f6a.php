<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>欢迎界面</title>
		<link type="text/css" rel="stylesheet" href="http://localhost:8080/freeBicycle/Public/easyui/themes/bootstrap/easyui.css">
		<link type="text/css" rel="stylesheet" href="http://localhost:8080/freeBicycle/Public/easyui/themes/icon.css">
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/easyui/locale/easyui-lang-zh_CN.js"></script>
		<style type="text/css">
			ul,li{list-style:none;}
		</style>
		<script type="text/javascript">
		function addTabs(title, url){
			var b = $("#tabs").tabs("exists", title);
			var myaccount = <?php echo ($_SESSION['loginUser']['ad_account']); ?>;
			if(b){
				$("#tabs").tabs("select", title);
				$('#tabs').tabs('update', {
					tab: $("#tabs").tabs("getTab", title),
					options:{}
				});
			}else{
				$('#tabs').tabs('add',{
					title: title,
					selected: true,
					closable: true,
					content:'<iframe src="'+url+"/myacc/"+myaccount+'" width="100%" height="100%" frameborder="0" scrolling="auto"></iframe>'
				});
			}
		};
		
		$(function(){
    		//行程表
			$("#calendar").calendar({
				current:new Date(),
				fit:true,
				formatter: function(date){
    				var today = dateToStr(new Date());
    				var tommrow = dateToStr(new Date(new Date().getTime()+24*60*60*1000));
    				var tommrow2 = dateToStr(new Date(new Date().getTime()+24*60*60*1000*2));
    				if(dateToStr(date) == today){
        				$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadBicycleJourney?searchDate="+today,function(data){
							$("#scheduleTagToday").text(data);
            			},"text");
    					return "<a class='calendarShow' title='点击查看当天单车行程'><span class='date'>"
    					+date.getDate()+"</span><br/><span class='text' id='scheduleTagToday'></span></a>";
        			}else if(dateToStr(date) == tommrow){
        				$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadBicycleJourney?searchDate="+tommrow,function(data){
							$("#scheduleTagTommrow").text(data);
            			},"text");
        				return "<a class='calendarShow' title='点击查看当天单车行程'><span class='date'>"
    					+date.getDate()+"</span><br/><span class='text' id='scheduleTagTommrow'></span></a>";
            		}else if(dateToStr(date) == tommrow2){
            			$.post("http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadBicycleJourney?searchDate="+tommrow2,function(data){
							$("#scheduleTagTommrow2").text(data);
            			},"text");
            			return "<a class='calendarShow' title='点击查看当天单车行程'><span class='date'>"
    					+date.getDate()+"</span><br/><span class='text' id='scheduleTagTommrow2'></span></a>";
                	}
    				return "<a class='calendarShow' title='点击查看当天单车行程'><span class='date'>"
					+date.getDate()+"</span><br/><span class='text' class='scheduleTag'></span></a>";
				},
				onSelect: function(date){
					var y = date.getFullYear();
					var m = date.getMonth()+1;
					var d = date.getDate();
					addTabs("单车行程"+y+"-"+m+"-"+d,"http://localhost:8080/freeBicycle/index.php/Home/BicycleJourneyZJ/loadBicycleJourney");
				}		 
			});
		});
		</script>
	</head>
	<body class="easyui-layout">   
        <div data-options="region:'north',split:false,collapsible:false" style="height:50px;line-height:50px;">
        	<span>欢迎你，<?php echo ($_SESSION['loginUser']['ad_account']); ?>!</span>
        	<a href="http://localhost:8080/freeBicycle/Application/Home/View/XJ/LoginView.php">退出</a>
        </div>   
        <div data-options="region:'west',title:'系统菜单',split:true" style="width:200px;">
        	<ul class="easyui-tree" animate='true' lines='true'> 
        		<!-- 循环遍历数据 -->
        		<?php if(is_array($_SESSION['menus'])): $i = 0; $__LIST__ = $_SESSION['menus'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m1): $mod = ($i % 2 );++$i; if($m1["me_leavel"] == 1): ?><li>
        					<span><?php echo ($m1["me_name"]); ?></span>
        					<ul>
        						<?php $mid1 = $m1["me_id"]; ?>
        						<?php if(is_array($_SESSION['menus'])): $i = 0; $__LIST__ = $_SESSION['menus'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m2): $mod = ($i % 2 );++$i; if($m2["me_leavel"] == 2 AND $m2["me_parentid"] == $mid1): ?><li>
        									<span><?php echo ($m2["me_name"]); ?></span>
        									<ul>
        										<?php $mid2 = $m2["me_id"]; ?>
        										<?php if(is_array($_SESSION['menus'])): $i = 0; $__LIST__ = $_SESSION['menus'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m3): $mod = ($i % 2 );++$i; if($m3["me_leavel"] == 3 AND $m3["me_parentid"] == $mid2): ?><li>
        													<a onclick="javascript:addTabs('<?php echo ($m3["me_name"]); ?>','<?php echo ($m3["me_url"]); ?>')"><?php echo ($m3["me_name"]); ?></a>
        												</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        									</ul>
        								</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        					</ul>
        				</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>	
            </ul> 
        </div>   
        <div id='tabs' data-options="region:'center'" class="easyui-tabs" style="background:#eee;">       	  
            <div title="点击日期查看单车行程信息" style="padding: 30px">
				<div class="easyui-calendar" id="calendar" style="border: 0"></div>
			</div>         
        </div>   		
	</body>
</html>