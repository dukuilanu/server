<!--  frequency limits:
governor response 59.5-60.5
gen trip 58.5-61.5
damage 57.5-62.5 
https://info.ornl.gov/sites/publications/Files/Pub57419.pdf -->
<?php
$conn = mysqli_connect("localhost","root","Apik0r0s","home");
$return = mysqli_query($conn,"SELECT timestamp AS stamp, freq AS freq FROM freq WHERE timestamp > '". (time() - (60*60*2)) ."';");
$array_out = "[60";
$array_counter = "[1";
$count = 2;
while ($row = mysqli_fetch_array($return)){
	$array_out = $array_out . "," . $row['freq'];
	$array_counter = $array_counter . "," . $count;
	$count++;
}
$array_out = $array_out . "]";
$array_counter = $array_counter . "]";
?>

<html>
<head>
<script src="chart.js/dist/chart.js"></script>
</head>

<body>
<div>
<canvas id="myChart" width="400" height="400"></canvas>
<script>
const ctx = document.getElementById('myChart');
var xValues = <?php echo $array_counter; ?>;
var yValues = <?php echo $array_out; ?>;

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      data: yValues
    }]
  }
});
</script>
</div>
</body>
</html>
