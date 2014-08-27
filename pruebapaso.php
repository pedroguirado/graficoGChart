<html>
	<head>
		<title>Probando graficos.php</title>
		<meta charset="UTF-8">
		
	</head>
	<body>
		<h1>Probando Graficos.php</h1>
		<p>El siguiente formulario me servirá para probar el envío de parámetros para la generación de gráficos.</p>
		<form method="post" action="php/graficos.php" id="formulario" name="formulario" >
			Número de gráficos: <input type="text" name="numerograficos" maxlength="1" size="5" value="1"><br>
			<div style="background:#dedede">
				Gráfico 1:
				<select name="tipografico1">
					<option value="PieChart">PieChart</option> 
					<option value="BarChart">BarChart</option>
					<option value="ColumnChart">ColumnChart</option>
					<option value="ScatterChart">ScatterChart</option>
					<option value="LineChart">LineChart</option>
					<option value="AreaChart">AreaChart</option>
					<option value="ClandestickChart">ClandestickChart</option>
					<option value="Histogram">Histogram</option>
					<option value="Gauge">Gauge</option>
					<option value="Table">Table</option>
					<option value="Map">Map</option>								
				</select><br/>
				 <textarea rows="4" cols="50" name="opciones1">
{"title": "Mi primera prueba con JSON",
"width": 400,
"height": 300,
"is3D": true}
				</textarea> 
				<textarea  rows="4" cols="80" name="consulta1">SELECT sum(piña) as Piña, sum(atun) as Atún, sum(pepperoni) as Pepperoni, sum(aceitunas) as Aceitunas, sum(cebolla) as Cebolla, sum(champiñones) as Champiñones from pizzas;</textarea>
				<!--<textarea  rows="4" cols="80" name="columnas1">{"nombre": "Ingredientes", "tipo": "string", "nombre": "Trozos", "tipo": "number"}</textarea>
				-->
				<textarea  rows="4" cols="80" name="columnas1">{"nombre0": "Ingredientes", "nombre1": "Trozos"}</textarea>
			</div>
			
			
			<div style="background:#aadede">
				Gráfico 2:
				<select name="tipografico2">
					<option value="PieChart">PieChart</option> 
					<option value="BarChart">BarChart</option>
					<option value="ColumnChart">ColumnChart</option>
					<option value="ScatterChart">ScatterChart</option>
					<option value="LineChart">LineChart</option>
					<option value="AreaChart">AreaChart</option>
					<option value="ClandestickChart">ClandestickChart</option>
					<option value="Histogram">Histogram</option>
					<option value="Gauge">Gauge</option>
					<option value="Table">Table</option>
					<option value="Map">Map</option>								
				</select><br/>
				 <textarea rows="4" cols="50" name="opciones2">
{"title": "Pizza que me comí anoche",
"width": 500,
"page": "enable",
"pageSize": 5}
				</textarea> 
				<textarea  rows="4" cols="80" name="consulta2">SELECT ciudad, pizzeria, precio from pizzas;</textarea>
				<textarea  rows="4" cols="80" name="columnas2">{"ncolumnas": 3, "nombre0": "Ciudad", "tipo0": "string",
					"nombre1": "Pizzería", "tipo1": "string", "nombre2": "Precio", "tipo2" : "number" }</textarea>
	  


			</div>	
			
			
			<div style="background:#ddaade">
				Gráfico 3:
				<select name="tipografico3">
					<option value="PieChart">PieChart</option> 
					<option value="BarChart">BarChart</option>
					<option value="ColumnChart">ColumnChart</option>
					<option value="ScatterChart">ScatterChart</option>
					<option value="LineChart">LineChart</option>
					<option value="AreaChart">AreaChart</option>
					<option value="ClandestickChart">ClandestickChart</option>
					<option value="Histogram">Histogram</option>
					<option value="Gauge">Gauge</option>
					<option value="Table">Table</option>
					<option value="Map">Map</option>								
				</select><br/>
				 <textarea rows="4" cols="50" name="opciones3">
{"title": "Mi primera prueba con JSON",
"width": 400,
"height": 300,
"is3D": true}
				</textarea> 
				<textarea  rows="4" cols="80" name="consulta3">SELECT sum(piña) as Piña, sum(atun) as Atún, sum(pepperoni) as Pepperoni, sum(aceitunas) as Aceitunas, sum(cebolla) as Cebolla, sum(champiñones) as Champiñones from pizzas;</textarea>
				<textarea  rows="4" cols="80" name="columnas3">{["nombre" => "Ingredientes", "tipo" => "string"], ["nombre" => "Trozos", "tipo" => "number"]}</textarea>
				
			</div>	
			
						
			
			
			<div style="background:#aadeaa">
				Gráfico 4:
				<select name="tipografico4">
					<option value="PieChart">PieChart</option> 
					<option value="BarChart">BarChart</option>
					<option value="ColumnChart">ColumnChart</option>
					<option value="ScatterChart">ScatterChart</option>
					<option value="LineChart">LineChart</option>
					<option value="AreaChart">AreaChart</option>
					<option value="ClandestickChart">ClandestickChart</option>
					<option value="Histogram">Histogram</option>
					<option value="Gauge">Gauge</option>
					<option value="Table">Table</option>
					<option value="Map">Map</option>								
				</select><br/>
				 <textarea rows="4" cols="50" name="opciones4">
{"title": "Mi primera prueba con JSON",
"width": 400,
"height": 300,
"is3D": true}
				</textarea> 
				<textarea  rows="4" cols="80" name="consulta4">SELECT sum(piña) as Piña, sum(atun) as Atún, sum(pepperoni) as Pepperoni, sum(aceitunas) as Aceitunas, sum(cebolla) as Cebolla, sum(champiñones) as Champiñones from pizzas;</textarea>
				<textarea  rows="4" cols="80" name="columnas4">{["nombre": "Ingredientes", "tipo": "string"], ["nombre": "Trozos", "tipo": "number"]}</textarea>
				
			</div>	
			
						
	Servidor: <input type="text" name="servidorbd" value="localhost" size="15">
	Usuario: <input type="text" name="usuariobd" value="pruebas" size="15">
	Contraseña: <input type="text" name="passwbd" value="probando" size="15">
	BD: <input type="text" name="bd" value="mispruebas" size="15">
	<br/><br/>
			<input type="submit" name="enviar" value="Envía formulario"></input>
			
		</form>
		
		
	</body>
</html>