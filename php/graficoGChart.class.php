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
	 * @param tipografico:
	 * 		PieChart, BarChart,
	 * 
	 * @param $servidorBD, $usuarioBD, $passwBD, $bd
	 * 		para conectarse a la base de datos de la que extraeremos los datos
	 * 
	 * @param $columnas
	 * 		Nombre de las columnas de la tabla de datos. Será un array bidimensional [numero][tipo] y [numero][nombre]
	 * 
	 * @param $opciones : Es un array que contendrá las distintas opciones
	 *  		- $opciones['title']: Frase que aparece sobre el gráfico. Puede estar vacía o ser NULL
	 * 
	 * */
	 
	function dibujaGrafico($tipografico,$servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta, $opciones){
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
		$this->creaTablaDatos($servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta);
		
		 // Opciones del gráfico
		$this->creaOpcionesGrafico($opciones); 
		
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
	 * @param $servidorBD, $usuarioBD, $passwBD, $bd
	 * 		para conectarse a la base de datos de la que extraeremos los datos
	 * 
	 * @param $columnas
	 * 		Nombre de las columnas de la tabla de datos. Será un array bidimensional [numero][tipo] y [numero][nombre]
	 */
	private function creaTablaDatos($servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta){
	
	echo"        var datos = new google.visualization.DataTable();
        datos.addColumn('".$columnas[0]["tipo"]."', '".$columnas[0]["nombre"]."');
        datos.addColumn('".$columnas[1]["tipo"]."', '".$columnas[1]["nombre"]."');\n ";
    
	$mysqli = new mysqli($servidorBD,$usuarioBD,$passwBD,$bd);
	if ($mysqli->connect_errno) {
   	 	echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$acentos = $mysqli->query("SET NAMES 'utf8'"); // Para no tener problema con las tildes ni eñes
	$consulta = $mysqli->real_escape_string($consulta); // Para evitar Inyección SQL
	
	if ($resultado = $mysqli->query($consulta)) {
		echo "\n	datos.addRows([";	
		$nfilastabla=$mysqli->field_count;
		$i=1;
		$fila = $resultado->fetch_assoc();
		
		while ($finfo = $resultado->fetch_field()) {
			$nombrecampo=$finfo->name;

			echo "['".$nombrecampo."', ".$fila[$nombrecampo]."]";
			$i++;
			if ($i<=$nfilastabla){
				echo ",";
			}
			echo "\n";
    	}
			
        echo"\n 	]);	
		";   	

    	/* liberar el conjunto de resultados */
    	$resultado->free();
    	$mysqli->close();
	}
	


	}
	
	/*******************************************************************************
	 * Esta función crea las opciones del gráfico.
	 * El resultado del echo debe ser parecido al siguiente:
	 * 
	 *         var opciones = {'title':'Pizza que me comí anoche',
        					   'width':400,	
        					   'height':300};
	 * @param $opciones : Es un array que contendrá las distintas opciones
	 *  		- $opciones['title']: Frase que aparece sobre el gráfico. Puede estar vacía o ser NULL
	 */
	private function creaOpcionesGrafico($opciones){
		echo "    var opciones = {'title':'".$opciones['title']."'";
        echo ",\n		'width':400";	
        echo ",\n		'height':300";
		echo "\n		};";
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
