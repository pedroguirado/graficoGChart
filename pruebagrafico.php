<?php
include ("php/graficoGChart.class.php");
?>
<!DOCTYPE html>
<html lang="es">
  <head>
  	<title>Probando Google Charts</title>

        <!--Carga la API de AJAX -->
	<meta charset="utf-8">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Carga el API de Visualizacion y el paquete del gráfico de quesitos
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Cuando la API de Visualización de Google está cargada llama a la función dibujaGrafico.
      google.setOnLoadCallback(dibujaGrafico);
	  google.setOnLoadCallback(dibujaGrafico2);
      // Llama a la función que crea y rellena la tabla,
      // crea el gráfico de quesitos, la pasa los datos y
      // lo dibuja.
      function dibujaGrafico() {

        // Crea la tabla de datos.
        var datos = new google.visualization.DataTable();
        datos.addColumn('string', 'Ingredientes');
        datos.addColumn('number', 'Trozos');
        datos.addRows([
          ['Setas', 3],
          ['Champiñones', 8],
          ['Aceitunas', 1],
          ['Zucchini', 1],
          ['Pepperoni', 2]
        ]);

        // Opciones del gráfico
        var opciones = {'title':'Pizza que me comí anoche',
        				'width':400,	// Comprobado que no es necesario poner width y height, mejor al div
        				'height':300};

        // Crea y dibuja el gráfico, pasando algunas opciones.
        var grafico = 
new google.visualization.PieChart(
document.getElementById('capaGrafico'));
        grafico.draw(datos, opciones);
        

      }
      
      
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
    <div style="width:500px; height:300px" id="capaGrafico"></div>
    ddd
	<div style="width:500px; height:300px; background-color: grey" id="capaGrafico2"></div>
    </body>    
</html>
