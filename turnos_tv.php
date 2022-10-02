<?php
include("includes/header.php"); // Incluye css, librerias, datepicker
include("config/datos_conexion.php");
include_once("config/parametros.php");

$fecha = date("Y-m-d");  // Para cargar turnos agendados para la fecha actual 

?>	

<style type="text/css">
    h1{
      text-align:center;
      background:-moz-linear-gradient(top, #00F, #0CF);
      color: #FFF;
      margin: 0px auto;
      padding: 5px;
    }
    h2{
      text-align:center;
      margin: 5px auto;

    }
    h3{
      text-align:center;
      font:   #191970;
      padding: 1px;
    }

    .tabla1 {
      font-family: Arial Black;
      border-collapse: separate;
      border-spacing: 8px 10px;
     }
     .tabla2 {
      border-collapse: separate;
      border-spacing: 5px 10px;
     }

     .tabla3 {

      border-collapse: separate;
      border-spacing: 5px 10px;
     }


     th{
      background-color: #00008B;
      text-align:center;
      color: #FFF;
    }
    td{
      padding: 3px;
      border-radius: 15px;
      border-left:3px solid    #1d8348 ;
      border-right:8px solid    #1d8348  ;
    }
  </style>

  <script type="text/javascript">
    setTimeout("document.location=document.location",30000);
  </script>
<body>
<h1> <?php echo $uo?></h1>
<h2> Turnos en Consulta Externa <?php echo ":". date("d"."/"."m"."/"."Y")." Hora: ". date("H".":"."i"); ?></h2>

<?php
// Cuenta el numero de consultorios activos para establecer el limite de turnos a mostrar en el turnero
$sql_total_prof = "SELECT preparacion FROM tur_profesionales WHERE preparacion=1 ";
$profesionales=$base->prepare($sql_total_prof);
$profesionales->execute(array());
$num_profesionales=$profesionales->rowCount(); // Contar el numero de registros

/* Recuperando registros de la bd para mostrar los turnos llamados por el profesional detalle
        estado = 0 registrado
        estado = 1 preparado
        estado = 2 llamado
        estado = 3 enviado espera
        estado = 4 atendido
*/
$registros=$base->query("SELECT t.idturno, t.id_prof, t.fecha_turno, t.hora_turno, t.observacion, p.apellidos,\n"
. "p.nombres, m.profesional, m.servicio, t.conteo, t.estado\n"
. "FROM `tur_diarios` AS t\n"
. "INNER JOIN pacientes AS p ON t.hcun = p.hcu\n"
. "INNER JOIN tur_profesionales AS m ON t.id_prof = m.idprof\n"
. "WHERE t.fecha_turno='$fecha' AND t.estado=2 ORDER BY t.fecha_prepara ASC LIMIT $num_profesionales")->fetchAll(PDO::FETCH_OBJ);

?>	
	<table class="tabla1" width="99%" border="2" align="center">
    <tr>
      <th><h4>Paciente</h3></th>
      <th><h4>Consultorio Asignado</h3></th>
      </tr> 
	<?php
		foreach($registros as $fila):?> 
   	<tr>
       <td><p style="color:Black; font-size:<?php echo $tamanoLetraPaciente?>;"> <?php echo $fila->apellidos.' '.$fila->nombres.' '.$fila->observacion?></p></td>
       
       <td class="p-3 mb-2 bg-success"><p style="color:#6e2c00; font-size:<?php echo $tamanoLetraConsultorio?>;"> <?php echo $fila->profesional?></p></td>
       

    </tr> 
	<?php
	endforeach;
	?>
  </table>

<?php
// Cuenta el numero turnos en espera siempre que sea la fecha actual, estado=1 preparado 
$sql_total_preparado = "SELECT estado FROM tur_diarios WHERE fecha_turno='$fecha' AND estado=1";
$preparado=$base->prepare($sql_total_preparado);
$preparado->execute(array());
$num_preparado=$preparado->rowCount(); // Contar el numero de registros

// Cuenta el numero turnos en espera siempre que sea la fecha actual, estado = 3 enviado a espera
$sql_total_espera = "SELECT estado FROM tur_diarios WHERE fecha_turno='$fecha' AND estado=3";
$esperando=$base->prepare($sql_total_espera);
$esperando->execute(array());
$num_esperando=$esperando->rowCount(); // Contar el numero de registros

?>	

<?php echo '<p align="center";><b>Pacientes preparados:</b>'.($num_preparado + $num_esperando).'</p>'; ?>

<table class="tabla2" border="0" align="center">
  <?php
// Recuperando registros de la bd siempre que sea la fecha actual, estado=1 preparado  
$preparados=$base->query("SELECT t.idturno, t.id_prof, t.fecha_turno, t.hora_turno, p.apellidos,\n"
. "p.nombres, m.profesional, m.servicio, t.conteo, t.estado\n"
. "FROM `tur_diarios` AS t\n"
. "INNER JOIN pacientes AS p ON t.hcun = p.hcu\n"
. "INNER JOIN tur_profesionales AS m ON t.id_prof = m.idprof\n"
. "WHERE t.fecha_turno='$fecha' AND t.estado=1 ORDER BY t.fecha_prepara ASC")->fetchAll(PDO::FETCH_OBJ);
 ?>
<?php
		foreach($preparados as $preparado):?> 
   	<tr>
       <td class="bg-warning"><p style="color:Black; font-size:14px;"> <?php echo '<b>('.$preparado->profesional.')</b> &nbsp;&nbsp;'.$preparado->apellidos.' '.$preparado->nombres.'</b>&nbsp;&nbsp;'?></p></td>
       <td class="bg-warning"><p style="color:blue; font-size:16px ;">
                      <?php
                      if($preparado->estado==1){
                      echo 'Espere por favor...';}
                      if($preparado->estado==3){
                      echo 'Enviado Espera';}
                      
                      ?>
            </p>
       </td>

    </tr> 
	<?php
	endforeach;
	?>
  </table>

<br>
  <table class="tabla3" border="0" align="center">
  <?php
// Recuperando registros de la bd siempre que sea la fecha actual, estado=3 enviado a espera
$esperas=$base->query("SELECT t.idturno, t.id_prof, t.fecha_turno, t.hora_turno, p.apellidos,\n"
. "p.nombres, m.profesional, m.servicio, t.conteo, t.estado\n"
. "FROM `tur_diarios` AS t\n"
. "INNER JOIN pacientes AS p ON t.hcun = p.hcu\n"
. "INNER JOIN tur_profesionales AS m ON t.id_prof = m.idprof\n"
. "WHERE t.fecha_turno='$fecha' AND t.estado=3 ORDER BY t.fecha_prepara ASC")->fetchAll(PDO::FETCH_OBJ);
 ?>
<?php
		foreach($esperas as $espera):?> 
   	<tr>
     
      <td class="bg-danger"><p style="color:Black; font-size:14px;"> <?php echo '<b>('.$espera->profesional.')</b> &nbsp;&nbsp;'.$espera->apellidos.' '.$espera->nombres.'</b>&nbsp;&nbsp;'?></p></td>
                   <td class="bg-danger"><p style="color:Red; font-size:16px ;">
                      <?php
                      if($espera->estado==1){
                      echo 'Paciente Preparado: Espere por favor';}
                      if($espera->estado==3){
                      echo 'Enviado Espera';}
                      ?>
            </p>
       </td>

    </tr> 
	<?php
	endforeach;
	?>
  </table>

<footer>
<div align="left">
<!-- <audio  controls="controls" autoplay >
<source src="./interfaz/alerta2.mp3" type="audio/mp3"/> 
</audio> -->
</footer> 
</div> 

</body>
</html>