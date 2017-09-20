<!DOCTYPE html>
<html>
<head>
	<title>EDITAR</title>
	<!--CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(''); ?>bt/css/bootstrap.min.css">
	<!--JS-->
	<script src='<?php echo base_url("bt/js/jquery.min.js?version=".date('YmdHis')); ?>' type="text/javascript"></script>
	<script src='<?php echo base_url("bt/js/funcion.js?version=".date('YmdHis')); ?>' type="text/javascript"></script>
	<script>
		/*$(document).ready(function(){
			$('#txtNombre').focus();
			$('#modiclose').click(function(){
				//parent.jQuery.fancybox.getInstance().close();
				
			});
		});*/
	</script>
</head>
<body class="container" style="margin-top:18px;">
<table class="table table-bordered">
	<tr>
		<td>#ID</td>
		<td>NOMBRE</td>
		<td>EMAIL</td>
		<td></td>
	</tr>
	<?php foreach($query->result() as $q){ ?>
	<tr>
		<?php echo form_open("home/modificar/$q->REG_Cod"); ?>
		<td><input type="text" name="txtID" value="<?php echo $q->REG_Cod; ?>" class="form-control" disabled></td>
		<td><input type="text" name="txtNombre" id="txtNombre" value="<?php echo $q->REG_Nombre; ?>" class="form-control"></td>
		<td><input type="text" name="txtEmail" value="<?php echo $q->REG_Email; ?>" class="form-control"></td>
		<td>
			<!--<a href="javascript:;" id="modiclose" onclick="modificar(<?php echo $q->REG_Cod; ?>)" class="btn btn-default">
				<span class="glyphicon glyphicon-floppy-disk"></span>
			</a>-->
			<button type="submit" class="btn btn-default" id="modiclose">
				<span class="glyphicon glyphicon-floppy-disk"></span>
			</button>
		</td>
		<?php echo form_close(); ?>
	</tr>
	<?php } ?>
</table>
</body>
</html>