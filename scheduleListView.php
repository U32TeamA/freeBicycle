<!DOCTYPE html>
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
		<table class="table table-striped table-bordered table-condensed" style="margin-top:1%;">
			<tr>
				<th>单车编号</th>
				<th>单车型号</th>
				<th>单车行程情况</th>
				<th>单车投放时间</th>
			</tr>
			<foreach name="page.rows" item="bicycle">
				<tr>
					<td>{$bicycle.bi_no}</td>
					<td>{$user.bi_model}</td>
					<td>{$user.bi_journey}</td>
					<td>{$user.bi_putTime}</td>
				</tr>
			</foreach>
		</table>
	</body>
</html>