<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title>单车行程列表</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="http://localhost:8080/freeBicycle/Public/bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/freeBicycle/Public/bootstrap/js/bootstrap.min.js"></script>
		<style type="text/css">

        </style>
		<script type="text/javascript">
			
		</script>
	</head>
	<body>
		<table class="table table-striped table-bordered table-condensed" style="width:98%;margin:10px 10px 0 10px;">
			<tr>
				<th>单车编号</th>
				<th>单车型号</th>
				<th>单车行程情况(单位：千米)</th>
				<th>单车投放时间</th>
			</tr>
			<?php if(is_array($page["rows"])): foreach($page["rows"] as $key=>$rows): ?><tr>
					<td><?php echo ($rows["bi_no"]); ?></td>
					<td><?php echo ($rows["bi_model"]); ?></td>
					<td><?php echo ($rows["bi_journey"]); ?></td>
					<td><?php echo ($rows["bi_puttime"]); ?></td>
				</tr><?php endforeach; endif; ?>
		</table>
	</body>
</html>