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
	</head>
	<body>
		<div class="table-responsive">
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