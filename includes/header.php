<DOCTYPE html>
<html lang="es">
<head>
			<meta charset="UTF-8">
			<title>Dirección Distrital 17D10</title>
			<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
			<link href="interfaz/css/all.min.css" rel="stylesheet" type="text/css">
			<style>
		   @import url('lib/bootstrap/css/bootstrap-datepicker.css');
		   @import url('lib/bootstrap/css/fontello.css');
			</style>

<script src="lib/jquery/jquery-3.1.1.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>	
<script src="lib/bootstrap/js/bootstrap-datepicker.js"></script> 
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
<script>
                // Llamando a datepicker
                $(function(){
                    $('.datepicker').datepicker({
                        language: "es",	
						format: "yyyy-mm-dd", // No cambiar por / afecta a la url que se envia por $_GET https://uxsolutions.github.io/bootstrap-datepicker/
						todayBtn: true,
    					clearBtn: true,
						daysOfWeekHighlighted: "0,6",
					 });
                });    
</script>  			
</head>