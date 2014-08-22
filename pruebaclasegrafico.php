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
	  ?>
     
      
      google.setOnLoadCallback(dibujaGrafico2);
      function dibujaGrafico2() {

        // Crea la tabla de datos.
        var datos = new google.visualization.DataTable();
        datos.addColumn('string', 'Ingredientes');
        datos.addColumn('number', 'Trozos');
        datos.addRows([
          ['Setas', 3],
          ['Champiñones', 8],
          ['Aceitunas', 1],
          ['Piña', 7],
          ['Pepperoni', 2]
        ]);

        // Opciones del gráfico
        var opciones = {'title':'Pizza que me comí anoche',
        				'width':500,	// Comprobado que no es necesario poner width y height, mejor al div
        				'height':400};

        
        var grafico2 = 
new google.visualization.BarChart(
document.getElementById('capaGrafico2'));
        grafico2.draw(datos, opciones);
      }

      
      
    </script>
  </head>
    <body>
    	<!-- DIV que contiene el gráfico -->
    <div style="width:500px; height:300px" id="capagrafico1"></div>
    ddd
	<div style="width:500px; height:300px; background-color: grey" id="capaGrafico2"></div>
    </body>    
</html>
