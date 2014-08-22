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

y luego una llamada a una función cuando se haya cargado la librería:


      	// Set a callback to run when the Google Visualization API is loaded.
      	google.setOnLoadCallback(drawChart);

drawChart será el nombre de la función a llamar