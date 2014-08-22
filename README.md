graficoGChart
=============

Creación de Gráficos con Google Chart

Voy a utilizar la API Javascript de Google Chart para generar gráficos.
https://google-developers.appspot.com/chart/

¿Cómo hacer que una página muestre un Google Chart?
---------------------------------------------------
0. Carbar la librería de AJAX
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

1. Cargar la librería de Visualización (Visualization API)

En un script javascript debemos incluir:

		// Load the Visualization API and the piechart package.
		google.load('visualization', '1.0', {'packages':['corechart']});

Aquí lo único que puede variar es la lista de packages a incluir. Valores posibles:
- corechart
- table

2. Una llamada a una función cuando se haya cargado la librería para dibujar el gráfico:


      	// Set a callback to run when the Google Visualization API is loaded.
      	google.setOnLoadCallback(drawChart);

drawChart será el nombre de la función a llamar

Dentro de esta función habrá que hacer varias cosas:

	2.1. Crear la tabla de datos
	var datos = new google.visualization.DataTable();
	Y luego añadir las columnas y las filas a la tabla.
	
	2.2. Especificar las opciones del grafico
	var opciones = {'title':'Título del gráfico',
					'height': 300}
					
	2.3. Crear y dibujar el gráfico
	Para ello, dependiendo del tipo de gráfico (PieChart, BarChart...):
		// Crear Gráfico
		var grafico = new google.visualization.PieChart(document.getElementById('capaGrafico'));
		// Dibujar Gráfico
        grafico.draw(datos, opciones);

3. Un div con ID='capagrafico'
	Como en nuestra página podremos tener varios gráficos, tendremos 'capagrafico1', 'capagrafico2', etc.
	Eso implica que tengamos que crear tantas funciones de dibujo como gráficos haya.
	

Generación de Google Charts desde PHP
-------------------------------------

He generado una clase llamada graficoGChart.

Para acceder a ella tendrás que incluir el fichero:
	php/graficoGChart.class.php
en tu código fuente.

- Funciones de la clase


