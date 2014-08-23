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
      $grafico->cargaLibreriaVisualizacion('corechart');
	  $grafico->dibujaGrafico('PieChart');
	  $grafico->dibujaGrafico('BarChart');      
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
