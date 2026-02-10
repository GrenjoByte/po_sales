<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="<?php echo base_url();?>photos/icons/PNG/top_logo.png">
	<title>Home</title>
	<script src="<?php echo base_url();?>bootstrap/assets/js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>materialize/css/materialize.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>materialize/css/materialize.min.css">
	<script src="<?php echo base_url();?>materialize/js/materialize.js"></script>
	<script src="<?php echo base_url();?>materialize/js/materialize.min.js"></script>
	<style type="text/css">
		.long{
			width: 50%;
		}
	</style>
</head>
<body>
	<?php include 'notifications.php'; ?>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br><br>
		<br><br>
	<div align="center">
		<br>
		<a class="btn-large long" href="<?php echo base_url();?>index.php/inventory_controller/login">Login</a>
		<br>
		<br>
		<a class="btn-large long" href="<?php echo base_url();?>index.php/inventory_controller/registration">Register</a>
		<br>
		<br>
	</div>
	
</body>
<script type="text/javascript">
	M.AutoInit();
</script>
</html>