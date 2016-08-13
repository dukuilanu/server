<?php
$conn = mysqli_connect("localhost","root","Apik0r0s","home");
?>

<html>
<head>

</head>

<body>
<div id='main' style='position:absolute;height:100%;width:100%'>
	<div id='header' style='position:absolute;top:0px;height:100px'>
		Header Div
	</div>
	
	<div id='upstairsRow' style='position:absolute;top:100px;height:300px'>
		<table border='1'>
		<tr>
		<?php
		$return = mysqli_query($conn,"SELECT name AS name, temp AS temp FROM thermostat WHERE floor = 2;");
		while ($row = mysqli_fetch_array($return)) {
			echo "<td>" . $row["name"] . "<br />" . $row["temp"] . "</td>";
		}
		?>
		</tr>
		</table>
	</div>
	
	<div id='downstairsRow' style='position:absolute;top:400px;height:300px'>
		<table border='1'>
		<tr>
		<?php
		$return = mysqli_query($conn,"SELECT name AS name, temp AS temp FROM thermostat WHERE floor = 1;");
		while ($row = mysqli_fetch_array($return)) {
			echo "<td>" . $row["name"] . "<br />" . $row["temp"] . "</td>";
		}
		?>
		</tr>
		</table>
	</div>
</div>

</body>
</html>

