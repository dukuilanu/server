<html>

<body>
<div id="main" style="position:absolute">
  <div id="loop" style="position:absolute;top:0px;left:0px">
    Current Radar Loop<br />
	<img src="weather/loop.gif" />
  </div>
  
  <div id="graph" style="position:absolute;top:291px;left:610px">
	48 Hour graph<br />
	<img src="weather/48_graph.png" />
  </div>
  
  <div id="current" style="position:absolute;top:0px;left:610px;width:350px">
  Currently Outside
	<?php
	$conn = mysqli_connect("localhost","root","Apik0r0s","home");
	$return = mysqli_query($conn,"SELECT * FROM extLog ORDER BY date DESC LIMIT 1;");
	$result = mysqli_fetch_array($return);
  echo $result[0] . ":<br />";
	echo "Temperature: " . $result[1] . "<br />
	Humidity: " . $result[3] . "<br /><br />";
	
	$forecast = simplexml_load_file("weather/weather.xml");
	echo "Today, Low: " . $forecast->data[0]->parameters[0]->temperature[0]->value[0] . ", Next High: ";
	echo $forecast->data[0]->parameters[0]->temperature[1]->value[0] . "<br />";
	echo $forecast->data[0]->{'time-layout'}[0]->{'start-valid-time'}[0]['period-name'] . ": ";
	echo $forecast->data[0]->parameters[0]->weather[0]->{'weather-conditions'}[0]['weather-summary'] . "<br />";
	echo $forecast->data[0]->{'time-layout'}[0]->{'start-valid-time'}[1]['period-name'] . ": ";
	echo $forecast->data[0]->parameters[0]->weather[0]->{'weather-conditions'}[1]['weather-summary'] . "<br /><br />";
  echo "Office:<br />";
  $return = mysqli_query($conn,"SELECT temp AS temp, humi AS humi FROM thermostat where id = 2;");
	$result = mysqli_fetch_array($return);
  echo $result['temp'] . " degrees, " . $result['humi'] . "%<br />";

	?>
  </div>

</div>


</body>

</html>