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
      $grafico->cargaLibreriaVisualizacion('corechart');
	  $grafico->dibujaGrafico('PieChart',$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta, $opciones);
	  
	  $consulta2="SELECT ciudad, sum(piña) as Piña, sum(atun) as Atún, sum(pepperoni) as Pepperoni, sum(aceitunas) as Aceitunas, sum(cebolla) as Cebolla, sum(champiñones) as Champiñones from pizzas group by ciudad;";
	  $opciones['isStacked']=true;
	  $grafico->dibujaGrafico('BarChart',$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta2, $opciones); 
	  $opciones['isStacked']=false;  
	  $opciones['vAxis']=array("title" => "Year");
	  $grafico->dibujaGrafico('ColumnChart',$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta2, $opciones);    
	  ?>  
      
    </script>
  </head>
    <body>
    	<!-- DIV que contiene el gráfico -->
    <div id="capagrafico1"></div>
    ddd
	<div style="background-color: grey" id="capagrafico2"></div>
	<div id="capagrafico3"></div>
    </body>    
</html>
