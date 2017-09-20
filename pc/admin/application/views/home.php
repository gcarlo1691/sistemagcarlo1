<!DOCTYPE html>
<html>
<head>
	<title>home</title>
	<!--CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(''); ?>bt/js/fancybox/dist/jquery.fancybox.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(''); ?>bt/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(''); ?>bt/css/dataTables.bootstrap.min.css">
</head>
<body class="container" style="margin-top:18px;">
	<a href="<?php echo base_url() ?>index.php/home/ingresar" class="btn btn-default">HAS CLICK PARA REGISTRARTE</a>
	<a href="<?php echo base_url() ?>" class="btn btn-default">ACTUALIZAR</a>
	<div id="FrmResultado">
		<table id="table-list" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
	            <tr>
	                <th>#ID</th>
	                <th>NOMBRE</th>
	                <th>EMAIL</th>
	                <th>EDITAR / BORRAR</th>
	            </tr>
        	</thead>
	        <tbody>
	        </tbody>
		</table>
		<table
	</div>
	<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(''); ?>">
	<!--JS-->
	<script src='<?php echo base_url("bt/js/jquery.min.js?version=".date('YmdHis')); ?>' type="text/javascript"></script>
	<script src='<?php echo base_url("bt/js/jquery.dataTables.min.js?version=".date('YmdHis')); ?>' type="text/javascript"></script>
	<script src='<?php echo base_url("bt/js/dataTables.bootstrap.min.js?version=".date('YmdHis')); ?>' type="text/javascript"></script>
	<script src='<?php echo base_url("bt/js/bootstrap.min.js?version=".date('YmdHis')); ?>' type="text/javascript"></script>
	<script src='<?php echo base_url("bt/js/funcion.js?version=".date('YmdHis')); ?>' type="text/javascript"></script>
	<script type="text/javascript">
		var save_method;
		var table;
		$(document).ready(function() {
		    //$('#table-list').DataTable();
		     //datatables
		    table = $('#table-list').DataTable({ 

		        "processing": true, //Feature control the processing indicator.
		        "serverSide": true, //Feature control DataTables' server-side processing mode.
		        "order": [], //Initial no order.

		        // Load data for the table's content from an Ajax source
		        "ajax": {
		            "url": "<?php echo site_url('home/lista')?>",
		            "type": "POST"
		        },

		        //Set column definition initialisation properties.
		        "columnDefs": [
		        { 
		            "targets": [ -1 ], //last column
		            "orderable": false, //set not orderable
		        },
		        ],

		    });

		    //set input/textarea/select event when change value, remove class error and remove text help block 
		    $("input").change(function(){
		        $(this).parent().parent().removeClass('has-error');
		        $(this).next().empty();
		    });
		    /*$("textarea").change(function(){
		        $(this).parent().parent().removeClass('has-error');
		        $(this).next().empty();
		    });*/
		    /*$("select").change(function(){
		        $(this).parent().parent().removeClass('has-error');
		        $(this).next().empty();
		    });*/
		} );
		function editar(id)
		{
		    save_method = 'update';
		    $('#form')[0].reset(); // reset form on modals
		    $('.form-group').removeClass('has-error'); // clear error class
		    $('.help-block').empty(); // clear error string

		    //Ajax Load data from ajax
		    $.ajax({
		        url : "<?php echo site_url('home/editar/')?>/" + id,
		        type: "GET",
		        dataType: "JSON",
		        success: function(data)
		        {
		            $('[name="txtID"]').val(data.REG_Cod);
		            $('[name="txtNombre"]').val(data.REG_Nombre);
		            $('[name="txtEmail"]').val(data.REG_Email);
		            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
		            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error get data from ajax');
		        }
		    });
		}

		function reload_table()
		{
		    table.ajax.reload(null,false); //reload datatable ajax 
		}

		function save()
		{
		    $('#btnSave').text('DATOS GUARDANDO...'); //change button text
		    $('#btnSave').attr('disabled',true); //set button disable 
		    var url;

		    if(save_method == 'add') {
		        url = "<?php echo site_url('person/ajax_add')?>";
		    } else {
		        url = "<?php echo site_url('home/modificar')?>";
		    }

		    // ajax adding data to database
		    $.ajax({
		        url : url,
		        type: "POST",
		        data: $('#form').serialize(),
		        dataType: "JSON",
		        success: function(data)
		        {
		            if(data.status) //if success close modal and reload ajax table
		            {
		                $('#modal_form').modal('hide');
		                reload_table();
		            }
		            else
		            {
		                for (var i = 0; i < data.inputerror.length; i++) 
		                {
		                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
		                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
		                }
		            }
		            $('#btnSave').text('GUARDAR'); //change button text
		            $('#btnSave').attr('disabled',false); //set button enable 
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('ERROR EN AGREGAR / ACTUALIZAR DATOS');
		            $('#btnSave').text('GUARDAR'); //change button text
		            $('#btnSave').attr('disabled',false); //set button enable 

		        }
		    });
		}

		function eliminar(id)
		{
		    if(confirm('ESTAS SEGURO QUE DESEAS BORRAR EL DATO?'))
		    {
		        // ajax delete data to database
		        $.ajax({
		            url : "<?php echo site_url('home/eliminar')?>/"+id,
		            type: "POST",
		            dataType: "JSON",
		            success: function(data)
		            {
		                //if success reload ajax table
		                $('#modal_form').modal('hide');
		                reload_table();
		            },
		            error: function (jqXHR, textStatus, errorThrown)
		            {
		                alert('ERROR EN BORRAR EL DATO');
		            }
		        });

		    }
		}
	</script>
	<!--////////////////////MODAL//////////////////////////////////////////////-->
	<!-- Bootstrap modal -->
	<div class="modal fade" id="modal_form" role="dialog">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">EDICION DE DATOS</h3>
	            </div>
	            <div class="modal-body form">
	                <form action="#" id="form" class="form-horizontal">	                	
	                    <input type="hidden" value="" name="txtID"/> 
	                    <div class="form-body">
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Nombre</label>
	                            <div class="col-md-9">
	                                <input name="txtNombre" class="form-control" type="text" >
	                                <span class="help-block"></span>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Email</label>
	                            <div class="col-md-9">
	                                <input name="txtEmail" class="form-control" type="text">
	                                <span class="help-block"></span>
	                            </div>
	                        </div>
	                    </div>
	                </form>
	            </div>
	            <div class="modal-footer">
	                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
	                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- End Bootstrap modal -->
</body>
</html>