<?php

//setup a call to the MySQL database and execute it
$conn = mysqli_connect("localhost","root","Apik0r0s","test");

//find a random number
$rune = rand(1,24);

//Look up that rune
$return = mysqli_query($conn,"SELECT name AS name, description AS description, id AS id FROM runes WHERE id = " . $rune . ";");

//echo the result
while($row = mysqli_fetch_array($return)) {
  //echo $row["name"] . ": " . $row["description"] . "<br />";
  echo "<img src=runes/" . $row["id"] . ".png width='50px' height='100px'/> " . $row["description"] . "";
} 

?>
