<?php
/************************************
 * Este fichero recibirá como parámetros POST:
 * 
 * 
 * $POST['numerograficos']= Un número que debe ser mayor que 0
 * $POST['tipografico1'], $POST['tipografico2'], $POST['tipografico3'], $POST['tipografico4'], Tantos como 'numerograficos'
 * 
 * valores que puede tomar $POST['tipograficoN'] : 
 * 		- del paquete 'corechart': PieChart, BarChart , ColumnChart, ScatterChart, LineChart, AreaChart, ClandestickChart, Histogram
 * 		- del paquete 'gauge': Gauge
 * 		- del paquete 'table': Table
 * 		- del paquete 'map': Map
 *
 * $POST['servidorbd'] : nombre del servidor de base de datos al que conectarse
 * $POST['usuariobd'] : nombre del usuario de base de datos al que conectarse
 * $POST['passwbd'] : password del usuario de BD
 * $POST['bd'] : nombre de la base de datos a la que conectarse 
 * 
 * $POST['consulta1'], $POST['consulta2'], $POST['consulta3'], $POST['consulta4'], Tantas como 'numerograficos'
 * 		consulta : cadena SQL que ejecutará sobre la BD. Debe terminar en ;
 * 
 * $POST['opciones1'], $POST['opciones2'], $POST['opciones3'], $POST['opciones4'], Tantas como 'numerograficos'
 * 		formato JSON
 *  
 * $POST['columnas1'], $POST['columnas2'], $POST['columnas3'], $POST['columnas4'], Tantas como 'numerograficos'
 * 		pero solo si el gráfico es 'Piechart' o 'Table'
 * 		formato JSON  
 * 			Si es PieChart será: {"nombre0": "Ingredientes", "nombre1": "Trozos"}
 * 			Si es Table será: {"ncolumnas": número, "nombre0": "PrimeraColumna", "tipo0": "TipoPrimeraColumna", ... }
 * 					número >=1
 * 					tipoN = "number", "string", "boolean"
 * paquete : 'corechart', 'table', 'gauge','map'
 * 
 *  
 * 
 */

 function compruebaParametros(){
 	if (!isset($_POST['servidorbd']))
		return FALSE;
 	if (!isset($_POST['passwbd']))
		return FALSE;
	if (!isset($_POST['usuariobd']))
		return FALSE;
	if (!isset($_POST['bd']))
		return FALSE;
	if (!isset($_POST['numerograficos']))
		return FALSE;
	if (!isset($_POST['tipografico1']))
		return FALSE;
	if (!isset($_POST['consulta1']))
		return FALSE;		
	
	if (($_POST['tipografico1']=='PieChart')||($_POST['tipografico1']=='Table')){
		if (!isset($_POST['columnas1']))
			return FALSE;		
	}
	
	$num=intval($_POST['numerograficos']);
	if ($num<=0)
		return FALSE;
	
	if ($num>=2){
		for ($i=2;$i<=$num;$i++){
			if (!isset($_POST['tipografico'.$i]))
				return FALSE;
			if (!isset($_POST['consulta'.$i]))
				return FALSE;
			if (($_POST['tipografico'.$i]=='PieChart')||($_POST['tipografico'.$i]=='Table')){
				if (!isset($_POST['columnas'.$i]))
					return FALSE;		
			}
		}
	}	
 	return TRUE;
 }

if (!compruebaParametros()){
	header('Location: error.php');	
	die();
}
else{	

  include ("graficoGChart.class.php");
  $grafico = new graficoGChart();
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
  	<title>Generando Google Charts</title>
	<meta charset="utf-8">
	
	<link href="../css/grafico.css">
	
        <!--Carga la API de AJAX -->	
    <?php
    	$grafico->cargaAPIAjax();
    ?>
    <script type="text/javascript">

      // Carga el API de Visualizacion y el paquete del gráfico de quesitos
      <?php
      
      
      $grafico->cargaLibreriaVisualizacion($_POST);
      
      
      $servidorBD= $_POST['servidorbd'];
	  $usuarioBD=$_POST['usuariobd'];
	  $passwBD=$_POST['passwbd'];
	  $bd=$_POST['bd'];
	  
	  
	  $num= intval($_POST['numerograficos']);
	  for ($g=1; $g<=$num; $g++){
	  		$tipografico=$_POST['tipografico'.$g];
			$consulta=$_POST['consulta'.$g];
	  		$opciones=$_POST['opciones'.$g];	
			if (($tipografico=='PieChart')||($tipografico=='Table')){
				$columnas=$_POST['columnas'.$g];
	  			$columnas=json_decode($columnas,TRUE); // TRUE para que haga array asociativo
			}
			else{
				$columnas=NULL;
			}
			$grafico->dibujaGrafico($tipografico,$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta, $opciones);
	  }
	  
	  ?>  
      
    </script>
  </head>
    <body>	
		<?php
		for ($i=1;$i<=$_POST['numerograficos'];$i++){
			echo "<div class='divgrafico' id='capagrafico".$i."'></div>\n";
		}
		?>	
    </body>    
</html>
