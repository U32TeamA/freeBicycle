<?php session_start();?>
<html>
	<head>
		<meta charset=utf-8>
		<title>登录</title>
		<link rel="stylesheet" href="http://localhost:8080/freeBicycle/Public/bootstrap/css/bootstrap.min.css">
		
		<script src="http://localhost:8080/freeBicycle/Public/bootstrap/js/jquery-1.11.0.min.js"></script>
		
		<script src="http://localhost:8080/freeBicycle/Public/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			
		</script>
		<style type="text/css">
        .panel{margin: auto;}
        body{background-image: url("http://localhost:8080/freeBicycle/Public/Image/11.jpg");background-size:100% 170%;background-repeat:no-repeat;}
		</style>
	</head>
	<body>
		<div class="container">
			<form role="form" class="form-horizontal" action="http://localhost:8080/freeBicycle/index.php/Home/Xujie/login" method="post" enctype="multipart/form-data" style="margin: 150px auto">
    			<div class="panel panel-info" style="width: 300px;">
    				<div class="panel-heading">
    			    		<div class="panel-title">请登录</div>
    			    </div>
    			    <div class="panel-body" >
        				<div class="form-group">					
        					<div class=" input-group"  style="margin-left:20px;margin-right:20px">
        						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
        						<input style="height: 40px;" id="ad_account" name="ad_account" class="form-control input-sm" placeholder="账号"/>
        					</div>
        				</div>
        				<div class="form-group">
        					<div class="input-group" style="margin-left:20px;margin-right:20px">
        						<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
        						<input style="height: 40px;" id="ad_password" name="ad_password" class="form-control input-sm" type="password" placeholder="密码"/>
        					</div>
        				</div>				
        				<div class="checkbox">
    			        	<label style="margin-top: -5px;margin-left:5px">
    			        		<input type="checkbox" value="remember-me"> 记住账号
    			        	</label>
    			        </div>
        				<button class="btn btn-info btn-block" type="submit">登录</button>
        				<span class='text-danger'>
        					<?php 
                    		 if(isset ($_REQUEST["error"])){
                    		     echo $_REQUEST["error"];
                    		 }
                    		 if(isset ($_SESSION["regNotice"])){
                    		     echo $_SESSION["regNotice"];
                    		     unset($_SESSION["regNotice"]);
                    		 }
                    		?>
        				</span>
            		</div>
        		</div>
    		</form>
		</div>
		
	</body>
</html>