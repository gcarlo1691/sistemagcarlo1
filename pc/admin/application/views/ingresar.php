<!DOCTYPE html>
<html>
<head>
	<title>INGRESAR</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(''); ?>bt/css/bootstrap.min.css">
</head>
<body>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<h1>INGRESAR DATOS</h1>
			<?php //echo validation_errors(); ?>
			<?php echo form_open('home/ingresar'); ?>
				<h5>Username</h5>
				<?php echo form_error('txtUsuario'); ?>
				<input type="text" name="txtUsuario" class="form-control" value="<?php echo set_value('txtUsuario'); ?>" size="15" />
				<h5>Password</h5>
				<?php echo form_error('txtPassword'); ?>
				<input type="password" name="txtPassword" class="form-control" value="<?php echo set_value('txtPassword'); ?>" size="15" />
				<h5>Password Confirm</h5>
				<?php echo form_error('passconf'); ?>
				<input type="password" name="passconf" class="form-control" size="15" />
				<h5>Email Address</h5>
				<?php echo form_error('txtEmail'); ?>
				<input type="text" name="txtEmail" class="form-control" value="<?php echo set_value('txtEmail'); ?>" size="15" />
				<div><input type="submit" value="Submit" class="btn btn-success" /></div>
			<?php echo form_close(); ?>
		</div>
	</div>
</body>
</html>