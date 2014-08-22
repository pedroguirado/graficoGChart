<?php
/* *************************************** 
 * Voy a desarrollar una clase que permita mostrar fácilmente en un div un gráfico de Google Chart
 * 
 * */
 
 class graficoGChart{
 	var $num=0;
	
	// ***************** Funciones **********************************************************
	function __construct() {
		$this->num=0;
	}

	function __destruct() {}
	
	function cargaAPIAjax(){
		echo '<script type="text/javascript" src="https://www.google.com/jsapi"></script>';
		echo "\n";
	}
	
	function cargaLibreriaVisualizacion($listapaquetes){
		/***********
		 * Esta función hará un echo de algo parecido a:
		 * 
		 * google.load('visualization', '1.0', {'packages':['corechart']});
		 * 
		 * @param listapaquetes
		 * 		será algo parecido a:
		 * 				corechart
		 * 				corechart, table
		 * 
		 * Dependiendo del tipo de gráfico que queramos visualizar, habrá que cargar distintos paquetes
		 * 
		 * Esta función debe llamarse justo después de crear:
		 * 
		 * <script type="text/javascript">
		 * 
		 */
		 
		 echo "google.load('visualization', '1.0', {'packages':['".$listapaquetes."']});";
		 
	}
	
	/********************************************************************************
	 * Esta función crea tanto la llamada a la función que dibuja el gráfico como la propia función
	 * 
	 * Para poder tener varios gráficos en la página utilizo la variable $num.
	 * Esta función dibujará el gráfico en un DIV. Es necesario que en el body de la página tengamos un DIV con ID='capagrafico1' (1 y consecutivos)
	 * 
	 * */
	 
	function dibujaGrafico($tipografico){
		$this->num++;
		$ngrafico = $this->num;
		// Cuando la API de Visualización de Google está cargada llama a la función dibujaGrafico.
		echo "\n\n";
		echo "	  google.setOnLoadCallback(dibujaGrafico".$ngrafico.");";
		echo "\n\n";
		
	  // Llama a la función que crea y rellena la tabla,
      // crea el gráfico de quesitos, la pasa los datos y
      // lo dibuja.
        echo "      function dibujaGrafico".$ngrafico."() {";
		echo "\n";
		
		// Crea la tabla de datos.
		$this->creaTablaDatos();
		
		 // Opciones del gráfico
		$this->creaOpcionesGrafico(); 
		
		// Crea y dibuja el gráfico, pasando algunas opciones.
		
		$this->creaGrafico($tipografico, $ngrafico);
		
		echo "\n}\n";
	}
	
	/*********************************************************************************
	 * 
	 * Esta función crea la tabla de datos para el gráfico.	 * 
	 * El resultado del echo debe ser parecido al siguiente:
	 * 
	 *      var datos = new google.visualization.DataTable();
        	datos.addColumn('string', 'Ingredientes');
        	datos.addColumn('number', 'Trozos');
        	datos.addRows([
          		['Setas', 3],
          		['Champiñones', 8],
          		['Aceitunas', 1],
          		['Zucchini', 1],
          		['Pepperoni', 2]
        	]);
	 * 
	 */
	private function creaTablaDatos(){
	
	echo"        var datos = new google.visualization.DataTable();
        datos.addColumn('string', 'Ingredientes');
        datos.addColumn('number', 'Trozos');
        datos.addRows([
          ['Setas', 3],
          ['Champiñones', 8],
          ['Aceitunas', 1],
          ['Zucchini', 1],
          ['Pepperoni', 2]
        ]);	
		";
	}
	
	/*******************************************************************************
	 * Esta función crea las opciones del gráfico.
	 * El resultado del echo debe ser parecido al siguiente:
	 * 
	 *         var opciones = {'title':'Pizza que me comí anoche',
        					   'width':400,	
        					   'height':300};
	 * 
	 */
	private function creaOpcionesGrafico(){
		echo "    var opciones = {'title':'Pizza que me comí anoche',
        		'width':400,	
        		'height':300};";
	}
	
	
	/*********************************************************************************
	 * Esta función crea el gráfico con los datos y opciones anteriores.
	 * El echo será algo parecido a lo siguiente:
	 * 
	 *         var grafico = 
				new google.visualization.PieChart(
				document.getElementById('capaGrafico'));
        		grafico.draw(datos, opciones);"
	 * 
	 * @param tipografico - Valores posibles:
	 * 		PieChart 		BarChart
	 * 
	 * @param n - número de gráfico
	 * 
	 */
	private function creaGrafico($tipografico, $n){
		echo "\n\n";
		echo "        var grafico = new google.visualization.".$tipografico."(
				document.getElementById('capagrafico".$n."'));
        		grafico.draw(datos, opciones);\n";
	} 
	 
	 
 } // Fin de la clase
?>
