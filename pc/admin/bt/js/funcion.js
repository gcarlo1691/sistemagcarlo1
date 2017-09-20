var base_url;
function editar($n)
{
	url = "http://localhost/pc/admin/index.php/home/editar/"+$n;
	$.post(url,function(data){
		$("#FrmResultado").html(data);
	});
	//location.href = url;
}
function modificar(n)
{
	url = "http://localhost/pc/admin/index.php/home/modificar/"+n;
	parent.jQuery.fancybox.getInstance().close();
	/*$.post(url,function(data){
		//$("#FrmResultado").html(data);
		//$("#modiclose").getInstance().close();
		location.href = "http://localhost/pc/admin";
		//parent.jQuery.fancybox.getInstance().close();
	});*/
}