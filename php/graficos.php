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


include ("graficoGChart.class.php");
$grafico = new graficoGChart();

?>
<!DOCTYPE html>
<html lang="es">
  <head>
  	<title>Generando Google Charts</title>
	<meta charset="utf-8">
	
        <!--Carga la API de AJAX -->	
    <?php
    	$grafico->cargaAPIAjax();
    ?>
    <script type="text/javascript">

      // Carga el API de Visualizacion y el paquete del gráfico de quesitos
      <?php
      
      $lista=$grafico->generaListaPaquetes($_POST);
      $grafico->cargaLibreriaVisualizacion($lista);
      
      
      $servidorBD= 'localhost';
	  $usuarioBD='pruebas';
	  $passwBD='probando';
	  $bd='mispruebas';
	  
	  $tipografico=$_POST['tipografico1'];
	  $columnas=$_POST['columnas1'];
	  $columnas=json_decode($columnas,TRUE); // TRUE para que haga array asociativo

	  $consulta=$_POST['consulta1'];
	  $opciones=$_POST['opciones1'];
	  $grafico->dibujaGrafico($tipografico,$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta, $opciones);
	  
	  
	  $tipografico=$_POST['tipografico2'];
	  $columnas=$_POST['columnas2'];
	  $columnas=json_decode($columnas,TRUE); // TRUE para que haga array asociativo

	  $consulta=$_POST['consulta2'];
	  $opciones=$_POST['opciones2'];
	  $grafico->dibujaGrafico($tipografico,$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta, $opciones);
/*	  // Columnas sí debo pasarlo como un array
	  $columnas=[
	  ["nombre" => "Ingredientes",
	  "tipo" => "string"],
	  ["nombre" => "Trozos",
	  "tipo" => "number"]
	  ];
	  
	  $consulta="SELECT sum(piña) as Piña, sum(atun) as Atún, sum(pepperoni) as Pepperoni, sum(aceitunas) as Aceitunas, sum(cebolla) as Cebolla, sum(champiñones) as Champiñones from pizzas;";

	  $opciones['title'] = "Pizza que me comí anoche";
	  $opciones['is3D'] = true;
	  $opciones['height'] = 300;
	  $opciones['width']=700;
	  $opciones['pieHole']=0.4;
	  //$opciones['pieStartAngle']=100;
	  $opciones['colors']= ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'];
      
	  $grafico->dibujaGrafico('PieChart',$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta, $opciones);
	  
	  $consulta2="SELECT ciudad, sum(piña) as Piña, sum(atun) as Atún, sum(pepperoni) as Pepperoni, sum(aceitunas) as Aceitunas, sum(cebolla) as Cebolla, sum(champiñones) as Champiñones from pizzas group by ciudad;";
	  $opciones['isStacked']=true;
	  $grafico->dibujaGrafico('BarChart',$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta2, $opciones); 
	  $opciones['isStacked']=false;  
	  $opciones['vAxis']=array("title" => "Year");
	  $grafico->dibujaGrafico('ColumnChart',$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta2, $opciones);  
	  
	  $consulta3="SELECT pepperoni as Pepperoni, aceitunas as Aceitunas from pizzas;";
	  $opciones2['title']="Comparo Pepperoni y Aceitunas";
	  $opciones2['height'] = 300;
	  $opciones2['width']= 500;	  
	  $opciones2['legend']='none';
	  $opciones2['vAxis']=['title'=>'Pepperoni'];
	  $opciones2['hAxis']=['title'=>'Aceitunas'];
	  $opciones2['pointShape']='triangle';
	  $grafico->dibujaGrafico('ScatterChart',$servidorBD,$usuarioBD,$passwBD,$bd, NULL, $consulta3, $opciones2); 
	  
	  $opciones['curveType']='function';
	  $opciones['lineWidth']=5;
	  //$opciones['backgroundColor']='#aa0000';
	  $opciones['pointSize']=10;
	  $grafico->dibujaGrafico('LineChart',$servidorBD,$usuarioBD,$passwBD,$bd, NULL, $consulta2, $opciones);
	  $grafico->dibujaGrafico('AreaChart',$servidorBD,$usuarioBD,$passwBD,$bd, NULL, $consulta2, $opciones);	
	  $opciones4['title']="Mi primer histograma";
	  $opciones4['legend']="none";
	  $opciones4['width']=400;
	  $opciones4['height']=600;
	  $opciones4['histogram']= ['bucketSize' => 7]; 
	  $consulta4="select pizzeria, precio from pizzas;";
	  $grafico->dibujaGrafico('Histogram',$servidorBD,$usuarioBD,$passwBD,$bd, NULL, $consulta4, $opciones4); 
	  $opciones5['title']="Mi primer candelabro";
	  $consulta5="SELECT ciudad, min( precio ) , precio, precio +4, max( precio ) FROM pizzas group by ciudad";
	  $grafico->dibujaGrafico('CandlestickChart',$servidorBD,$usuarioBD,$passwBD,$bd, NULL, $consulta5, $opciones5);
	  
	  
	  
	  $columnas6=[
	  ["nombre" => "Ciudad",
	  "tipo" => "string"],
	  ["nombre" => "Pizzería",
	  "tipo" => "string"],
	  ["nombre" => "Precio",
	  "tipo" => "number"]
	  ];
	  
	  $consulta6="SELECT ciudad, pizzeria, precio from pizzas;";

	  $opciones6['title'] = "Pizza que me comí anoche";
	  $opciones6['page'] ='enable';
	  $opciones6['pageSize'] = 5;
	  $opciones6['width']=500;
      
	  $grafico->dibujaGrafico('Table',$servidorBD,$usuarioBD,$passwBD,$bd, $columnas6, $consulta6, $opciones6);
	  
	  
	  
	  $opciones7['title']="Mi primer gauge";
	  $opciones7['redTo']=40;
	  $consulta7='select pizzeria, precio from pizzas where ciudad="Maracena" ;';
	  $grafico->dibujaGrafico('Gauge',$servidorBD,$usuarioBD,$passwBD,$bd, NULL, $consulta7, $opciones7);
	  
	  $opciones11['title']='Mi primer mapa';
	  //$opciones11['width']=900;
	  //$opciones11['height']=800;
	  //$opciones11['zoomLevel']=10;
	  $opciones11['showTip']=true; $opciones11['showLine']=true; $opciones11['lineColor']='#cccccc'; $opciones11['lineWidth']=15;
	  $opciones11['icons']=['default' => ['normal' => 'http://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Azure-icon.png']];
	  
	  $consulta11='select x, y, pizzeria from pizzas  where provincia="Granada" group by x, y;';
	  $grafico->dibujaGrafico('Map',$servidorBD,$usuarioBD,$passwBD,$bd, NULL, $consulta11, $opciones11);*/ 
	  ?>  
      
    </script>
  </head>
    <body>
    	<!-- DIV que contiene el gráfico -->
    <div id="capagrafico1"></div>
    ddd
	<div style="background-color: grey" id="capagrafico2"></div>
	<div id="capagrafico3"></div>
	<div id="capagrafico4"></div>
	<div id="capagrafico5"></div>
	<div id="capagrafico6"></div>
	<div id="capagrafico7"></div>
	<div id="capagrafico8"></div>
	<div id="capagrafico9"></div>
	<div id="capagrafico10"></div>
	<div style="width:500px" id="capagrafico11"></div>
	<p>kkkkkkkkkkk</p>
	<div>
		<?php
		echo $_POST['numerograficos'];
		for ($i=1;$i<=$_POST['numerograficos'];$i++){
			echo $_POST['tipografico'.$i]."<br/>\n";
			echo $_POST['consulta'.$i];
			echo "<br/><br/>\n";
			echo $_POST['opciones'.$i];
			echo "<br/><br/>\n";
			if (($_POST['tipografico'.$i]=="PieChart") || ($_POST['tipografico'.$i] == "Table")){
				echo $_POST['columnas'.$i];
			}
			echo "<br/><br/><br/>\n";
			
			echo "\n\n";
			echo "\n\n";
		}
		?>
		
		
	</div>
    </body>    
</html>
