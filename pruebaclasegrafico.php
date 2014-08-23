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
//	  $usuarioBD='root';
//	  $passwBD='gu1rado';
	  $bd='mispruebas';
	  
	  $columnas=[
	  ["nombre" => "Ingredientes",
	  "tipo" => "string"],
	  ["nombre" => "Trozos",
	  "tipo" => "number"]
	  ];
	  
	  $consulta="SELECT sum(`piña`) as `Piña`, sum(atun) as `Atún`, sum(pepperoni) as Pepperoni, sum(aceitunas) as Aceitunas, sum(cebolla) as Cebolla, sum(`champiñones`) as `Champiñones` from `pizzas`;";
	  $consulta="SELECT sum(piña) as Piña, sum(atun) as Atún, sum(pepperoni) as Pepperoni, sum(aceitunas) as Aceitunas, sum(cebolla) as Cebolla, sum(champiñones) as Champiñones from pizzas;";
	  //$consulta="SELECT sum(pepperoni) as Pepperoni, sum(aceitunas) as Aceitunas, sum(cebolla) as Cebolla from `pizzas`;";
	  //$consulta="select count(id) from pizzas;";
      
      $grafico->cargaLibreriaVisualizacion('corechart');
	  $grafico->dibujaGrafico('PieChart',$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta);
	  $grafico->dibujaGrafico('BarChart',$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta);      
	  ?>  
      
    </script>
  </head>
    <body>
    	<!-- DIV que contiene el gráfico -->
    <div style="width:500px; height:300px" id="capagrafico1"></div>
    ddd
	<div style="width:500px; height:300px; background-color: grey" id="capagrafico2"></div>
    </body>    
</html>
