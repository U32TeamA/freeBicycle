<?php
session_start();
?>
<html>
	<head>
		<meta charset=utf-8>
		<title>异常单车</title>
		<link rel="stylesheet" href="http://localhost:8080/freeBicycle/Public/bootstrap/css/bootstrap.min.css">		
		<script src="http://localhost:8080/freeBicycle/Public/bootstrap/js/jquery-1.11.0.min.js"></script>		
		<script src="http://localhost:8080/freeBicycle/Public/bootstrap/js/bootstrap.min.js"></script>		
		<style type="text/css">
            .glyphicon{
	           color: green;            }
            #searchForm input{
	              width: 33.3%;
            }

        </style>
	</head>
	<body>
	
		<div class="table-responsive"> 
			<div id="topbtn" class="btn-group">
				<button type="button" class="btn btn-default" >刷新
                  	<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                </button>
    			<button type="button" class="btn btn-default" >增加
                  	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-default" >修改
                  	<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-default" >导出excel
                  	<span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-default" >删除
                  	<span class="glyphicon glyphicon-trash" aria-hidden="true" style="color: red;"></span>
                </button>
                <form id="searchForm" action="#" method="post">
                    <div class="input-group">
    	   		  		<input type="text" class="form-control" placeholder="ID">
    			      	<input type="text" class="form-control" placeholder="单车编号">
    			      	<input type="text" class="form-control" placeholder="单车型号">
    			      	<span class="input-group-btn">
    			        	<button class="btn btn-default" type="submit">搜索</button>
    			      	</span>
        			 </div>
    			</form>
            </div>
            <table class="table">
            	<tr>
            		<th><input type="checkbox"></th>
            		<th>ID</th>
            		<th>行程</th>
            		<th>编号</th>
            		<th>型号</th>
            		<th>上线时间</th>
            		<th>状态</th>
            	</tr>
            	<?php 
            	   foreach ($_SESSION['rows'] as $value){
            	       echo "<tr><td><input type='checkbox'></td>";
            	       
            	       foreach ($value as $va){
            	           echo "<td>$va</td>";
            	       }
            	       echo "</tr>";
            	   }
            	
            	?>
            </table>
            
            
        </div>
        <div class="text-center">
        	<nav aria-label="Page navigation">
                <ul class="pagination">
                    <li>
                        <a href="#" aria-label="Previous">
                        	<span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php 
                        for ($i=0 ; $i<$_SESSION['totalPage'] ; $i++){
                            $j=$i+1;
                            echo "<li><a href='#'>$j</a></li>";
                        }
                    ?>
                    
                    <li>
                        <a href="#" aria-label="Next">
                        	<span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
	</body>