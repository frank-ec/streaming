<?php
include_once("config/parametros.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Turnos</title>

<link href="interfaz/css/estilostv.css" rel="stylesheet" type="text/css">
<style>
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
</style>

</head>
<body>
<div id="contenedor">
	<div id="cabecera">
		<h1>Uso de AWS Streaming</h1>
	</div>
	<div id="navegacion">
	</div>
	<div id="col_izquierda">
	<figure>
	
	<iframe src="<?php echo $streaming ?>"  width="100%" height="400"  frameborder="1" scrolling="yes" marginwidth="2" marginheight="4" align="right">
		
	</iframe>	

    </figure>  
	
	</div>
	<div id="col_derecha">
			
	
		<img src="interfaz/images/sala.png" width="50%" height="50%" class="center">
	
	</div>
	<div id="pie">
	</div>
</div>
</body>
</html>
