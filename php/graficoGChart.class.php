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
	 * 			- $opciones['is3D']: Si el gráfico es en 3D o no
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
		switch ($tipografico){
			
			case 'PieChart': 
				$this->creaTablaDatosPieChart($servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta);
				break;
			case 'BarChart': case 'ColumnChart': case 'LineChart': case 'AreaChart':
				$this->creaTablaDatosBarChart($servidorBD,$usuarioBD,$passwBD,$bd, $consulta);
				break;
			case 'ScatterChart':
				$this->creaTablaDatosScatterChart($servidorBD,$usuarioBD,$passwBD,$bd, $consulta);
				break;	
			case 'Histogram':
				$this->creaTablaDatosHistogram($servidorBD,$usuarioBD,$passwBD,$bd, $consulta);
				break;	
			case 'CandlestickChart':
				$this->creaTablaDatosCandlestickChart($servidorBD,$usuarioBD,$passwBD,$bd, $consulta);
				break;				
		}
		
		
		 // Opciones del gráfico
		$this->creaOpcionesGrafico($opciones); 
		
		// Crea y dibuja el gráfico, pasando algunas opciones.
		
		$this->creaGrafico($tipografico, $ngrafico);
		
		echo "\n}\n";
	}
	
	/********************************************************************************** 
	 * Esta función crea la tabla de datos para el gráfico de tipo PieChart.	  
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
	private function creaTablaDatosPieChart($servidorBD,$usuarioBD,$passwBD,$bd, $columnas, $consulta){
	
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

	/********************************************************************************** 
	 * Esta función crea la tabla de datos para el gráfico de tipo BarChart, ColumnChart, LineChart.	  
	 * El resultado del echo debe ser parecido al siguiente:
	 * 
var data = google.visualization.arrayToDataTable([
    ['Year', 'Sales', 'Expenses'],
    ['2004',  1000,      400],
    ['2005',  1170,      460],
    ['2006',  660,       1120],
    ['2007',  1030,      540]
]);
	 *
	 * @param $servidorBD, $usuarioBD, $passwBD, $bd
	 * 		para conectarse a la base de datos de la que extraeremos los datos
	 * 
	 * @param $columnas
	 * 		Nombre de las columnas de la tabla de datos. Será un array bidimensional [numero][tipo] y [numero][nombre]
	 * 
	 * @param $consulta
	 * 		En la primera columna tendremos el nombre de las distintas series. En las siguientes siempre tendrán que ser numéricas
	 */
	private function creaTablaDatosBarChart($servidorBD,$usuarioBD,$passwBD,$bd, $consulta){
	
	echo"        var datos = new google.visualization.arrayToDataTable([\n ";
    
	$mysqli = new mysqli($servidorBD,$usuarioBD,$passwBD,$bd);
	if ($mysqli->connect_errno) {
   	 	echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$acentos = $mysqli->query("SET NAMES 'utf8'"); // Para no tener problema con las tildes ni eñes
	$consulta = $mysqli->real_escape_string($consulta); // Para evitar Inyección SQL
	

	
	if ($resultado = $mysqli->query($consulta)) {
		// La primera fila la rellenamos con los nombres de los campos	
		$nfilastabla=$mysqli->field_count;
		$i=0;
		echo "[";		
		while ($finfo = $resultado->fetch_field()) {
			$nombrecampo=$finfo->name;
			echo "'".$nombrecampo."'";
			$i++;
			if ($i<$nfilastabla)
				echo ",";
		}
		echo "],\n";
		while ($fila = $resultado->fetch_array(MYSQLI_NUM)){
			echo "['".$fila[0]."'";
			$i=1;
			while ($i<$nfilastabla){				
				echo ", ".$fila[$i];
				$i++;
			}
			
			echo "],\n";
    	}
			
    	/* liberar el conjunto de resultados */
    	$resultado->free();
    	$mysqli->close();
	}
	
	echo "]);";

	}
	
		
    /********************************************************************************** 
	 * Esta función crea la tabla de datos para el gráfico de tipo ScatterChart.	  
	 * El resultado del echo debe ser parecido al siguiente:
	 * 
        var data = google.visualization.arrayToDataTable([
          ['Age', 'Weight'],
          [ 8,      12],
          [ 4,      5.5],
          [ 11,     14],
          [ 4,      5],
          [ 3,      3.5],
          [ 6.5,    7]
        ]);
	 *
	 * @param $servidorBD, $usuarioBD, $passwBD, $bd
	 * 		para conectarse a la base de datos de la que extraeremos los datos
	 * 
	 * 
	 * @param $consulta
	 * 		En la primera columna tendremos el nombre de las distintas series. En las siguientes siempre tendrán que ser numéricas
	 */
	private function creaTablaDatosScatterChart($servidorBD,$usuarioBD,$passwBD,$bd, $consulta){
	
	echo"        var datos = new google.visualization.arrayToDataTable([\n ";
    
	$mysqli = new mysqli($servidorBD,$usuarioBD,$passwBD,$bd);
	if ($mysqli->connect_errno) {
   	 	echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$acentos = $mysqli->query("SET NAMES 'utf8'"); // Para no tener problema con las tildes ni eñes
	$consulta = $mysqli->real_escape_string($consulta); // Para evitar Inyección SQL
	

	
	if ($resultado = $mysqli->query($consulta)) {
		// La primera fila la rellenamos con los nombres de los campos	
		$nfilastabla=$mysqli->field_count;
		$i=0;
		echo "[";		
		while ($finfo = $resultado->fetch_field()) {
			$nombrecampo=$finfo->name;
			echo "'".$nombrecampo."'";
			$i++;
			if ($i<$nfilastabla)
				echo ",";
		}
		echo "]";
		while ($fila = $resultado->fetch_array(MYSQLI_NUM)){
			echo ",\n		[".$fila[0].", ".$fila[1].",]";

			
			
    	}
			
    	/* liberar el conjunto de resultados */
    	$resultado->free();
    	$mysqli->close();
	}
	
	echo "\n]);";

	}
	
	/********************************************************************************** 
	 * Esta función crea la tabla de datos para el gráfico de tipo Histogram.	  
	 * El resultado del echo debe ser parecido al siguiente:
	 * 
var data = google.visualization.arrayToDataTable([
          ['Dinosaur', 'Length'],
          ['Acrocanthosaurus (top-spined lizard)', 12.2],
          ['Albertosaurus (Alberta lizard)', 9.1],
          ['Allosaurus (other lizard)', 12.2],
          ['Plateosaurus (flat lizard)', 7.9],
          ['Sauronithoides (narrow-clawed lizard)', 2.0],
          ['Seismosaurus (tremor lizard)', 45.7],
          ['Spinosaurus (spiny lizard)', 12.2],
          ['Supersaurus (super lizard)', 30.5],
          ['Tyrannosaurus (tyrant lizard)', 15.2],
          ['Ultrasaurus (ultra lizard)', 30.5],
          ['Velociraptor (swift robber)', 1.8]]);
	 *
	 * @param $servidorBD, $usuarioBD, $passwBD, $bd
	 * 		para conectarse a la base de datos de la que extraeremos los datos
	 * 
	 * 
	 * @param $consulta
	 * 		En la primera columna tendremos el nombre del elemento / nombre del valor numérico. Solo 2 columnas
	 */
	private function creaTablaDatosHistogram($servidorBD,$usuarioBD,$passwBD,$bd, $consulta){
	
	echo"        var datos = new google.visualization.arrayToDataTable([\n ";
    
	$mysqli = new mysqli($servidorBD,$usuarioBD,$passwBD,$bd);
	if ($mysqli->connect_errno) {
   	 	echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$acentos = $mysqli->query("SET NAMES 'utf8'"); // Para no tener problema con las tildes ni eñes
	$consulta = $mysqli->real_escape_string($consulta); // Para evitar Inyección SQL
	

	
	if ($resultado = $mysqli->query($consulta)) {
		// La primera fila la rellenamos con los nombres de los campos	
		$nfilastabla=$mysqli->field_count;
		$i=0;
		echo "[";		
		while (($finfo = $resultado->fetch_field())&&($i<2)) {
			$nombrecampo=$finfo->name;
			echo "'".$nombrecampo."'";
			$i++;
			if ($i<$nfilastabla)
				echo ",";
		}
		echo "]";
		while ($fila = $resultado->fetch_array(MYSQLI_NUM)){
			echo ",\n		['".$fila[0]."', ".$fila[1].",]";

			
			
    	}
			
    	/* liberar el conjunto de resultados */
    	$resultado->free();
    	$mysqli->close();
	}
	
	echo "\n]);";

	}
		
	
	
	
	
	
/********************************************************************************** 
	 * Esta función crea la tabla de datos para el gráfico de tipo CandlestickChart.	  
	 * El resultado del echo debe ser parecido al siguiente:
	 * 
    var data = google.visualization.arrayToDataTable([
      ['Mon', 20, 28, 38, 45],
      ['Tue', 31, 38, 55, 66],
      ['Wed', 50, 55, 77, 80],
      ['Thu', 77, 77, 66, 50],
      ['Fri', 68, 66, 22, 15]
      // Treat first row as data as well.
    ], true);
	 *
	 * @param $servidorBD, $usuarioBD, $passwBD, $bd
	 * 		para conectarse a la base de datos de la que extraeremos los datos
	 * 
	 * 
	 * @param $consulta
	 * 		Siempre 5 columnas. La primera de tipo string. No es necesaria fila cabecera
	 */
	private function creaTablaDatosCandlestickChart($servidorBD,$usuarioBD,$passwBD,$bd, $consulta){
	
	echo"        var datos = new google.visualization.arrayToDataTable([\n ";
    
	$mysqli = new mysqli($servidorBD,$usuarioBD,$passwBD,$bd);
	if ($mysqli->connect_errno) {
   	 	echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$acentos = $mysqli->query("SET NAMES 'utf8'"); // Para no tener problema con las tildes ni eñes
	$consulta = $mysqli->real_escape_string($consulta); // Para evitar Inyección SQL
	

	
	if ($resultado = $mysqli->query($consulta)) {
		// La primera fila la rellenamos con los nombres de los campos	

		while ($fila = $resultado->fetch_array(MYSQLI_NUM)){
			echo "\n		['".$fila[0]."', ".$fila[1].", ".$fila[2].", ".$fila[3].", ".$fila[4]."],";

			
			
    	}
			
    	/* liberar el conjunto de resultados */
    	$resultado->free();
    	$mysqli->close();
	}
	
	echo "\n], true);\n";

	}
		
	
	
	
	
	/*******************************************************************************
	 * Esta función crea las opciones del gráfico.
	 * El resultado del echo debe ser parecido al siguiente:
	 * 
	 *         var opciones = {title: 'Pizza que me comí anoche',
        					   width: 400,	
        					   height: 300};
	 * @param $opciones : Es un array que contendrá las distintas opciones
	 * 
	 * Comunes: 
	 * 			- $opciones['title']: Frase que aparece sobre el gráfico. Puede estar vacía o ser NULL
	 * 			- $opciones['width']: Anchura
	 * 			- $opciones['height']: Altura
	 * 			- $opciones['colors']: ['#aaaaaa', '#fffaff'] Para especificar los colores de las series
	 * 			- $opciones['hAxis']: array("title" => "Eje X")
	 * 			- $opciones['vAxis']: array("title" => "Eje Y")
	 * 			- $opciones['legend']: none, bottom, top, left, right
	 * 			- $opciones['backgroundColor']: color de fondo, en hexadecimal
	 * 	 
	 * Para un PieChart:  		
	 * 			- $opciones['is3D']: Si el gráfico es en 3D o no
	 * 			- $opciones['pieHole']: Entre 0 y 1, recomendable entre 0.4 y 0.6
	 *			- $opciones['pieStartAngle']: Dónde comienza el primer slice (Esto no es de interés)
	 * 
	 * Para un BarChart, ColumnChart y AreaChart:
	 * 			- $opciones['isStack']: true, para poner barras apiladas 
	 * 
	 * Para un ScatterChart:
	 * 			- Es recomendable poner hAxis y vAxis, así como poner legend a none
	 *  
	 * Para un LineChart: 
	 * 			- $opciones['curveType']= 'function' para que las líneas sean curvas
	 * 			- $opciones['lineWidth']: anchura de la línea. Por defecto es 2
	 * 			- $opciones['orientation']= 'vertical' Para poner el gráfico de líneas de forma vertical
	 * 			- $opciones['pointShape']:  'circle', 'triangle', 'square', 'diamond', 'star', or 'polygon'  --> También para ScatterChart y AreaChart
	 * 			- $opciones['pointShape']: 10, para expresar el tamaño del punto. Por defecto está a 0. --> También para ScatterChart y AreaChart
	 * 
	 * Para un Histogram:
	 * 			- $opciones['histogram']: ['lastBucketPercentile' => 5] Elimina el percentil 5 por arriba y por debajo
	 * 			- $opciones['histogram']: ['bucketSize' => 1000] Cambia el tamaño del cubo a 1000
	 * 
	 * 
	 * 			- $opciones['']:
	 * 
	 */
	private function creaOpcionesGrafico($opciones){
		$n = count($opciones);

		$i=0;
		echo "	var opciones = {";
		foreach ($opciones as $opcion => $valor){
			$comilla="";
			if (is_string($valor)){
				$comilla="'";
			}
			if (is_bool($valor)){				
				if ($valor==TRUE)
					$valor="true";
				else 
					$valor="false";
				
			}
			if (is_array($valor)) {
				if ($opcion=="colors"){
					echo "\n			".$opcion.": [";
					$n2=count($valor);
					$j=0;
					foreach($valor as $x => $y){
						$comilla2="";
						if (is_string($y))
							$comilla2="'";
						
						if (is_bool($y)){				
							if ($y==TRUE)
								$y="true";
							else 
							$valor="false";				
						}
						echo $comilla2.$y.$comilla2;
						$j++;
						if ($j<$n2)
							echo ",";	
			
					}
					echo "]";
				}
				else{   // Ejemplo--> hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
					echo "\n			".$opcion.": {";
	
					$n2=count($valor);
					$j=0;
					foreach($valor as $x => $y){
						$comilla2="";
						if (is_string($y))
							$comilla2="'";
						
						if (is_bool($y)){				
							if ($y==TRUE)
								$y="true";
							else 
							$valor="false";				
						}
						echo $x.": ".$comilla2.$y.$comilla2;
						$j++;
						if ($j<$n2)
							echo ",";	
					}	
					
					echo "}";
				}
			}
			else{
				echo "\n			".$opcion.": ".$comilla.$valor.$comilla;
			}
			$i++;
			if ($i<$n)
				echo ",";	

		}
		echo "\n	};";    			
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
