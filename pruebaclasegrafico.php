<?php
include ("php/graficoGChart.class.php");
$grafico = new graficoGChart();

?>
<!DOCTYPE html>
<html lang="es">
  <head>
  	<title>Probando Google Charts</title>
	<meta charset="utf-8">
	
        <!--Carga la API de AJAX -->	
    <?php
    	$grafico->cargaAPIAjax();
    ?>
    <script type="text/javascript">

      // Carga el API de Visualizacion y el paquete del gráfico de quesitos
      <?php
      
      
      $grafico->cargaLibreriaVisualizacion(array('corechart','table','gauge'));
      
      
      $servidorBD= 'localhost';
	  $usuarioBD='pruebas';
	  $passwBD='probando';
	  $bd='mispruebas';
	  
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
    </body>    
</html>
