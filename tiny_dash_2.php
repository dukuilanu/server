<?php
$conn = mysqli_connect("localhost","root","Apik0r0s","home");
$return = mysqli_query($conn,"SELECT * FROM extLog ORDER BY date DESC LIMIT 1;");
$result = mysqli_fetch_array($return);
echo round($result[1],1) . "F; " . round($result[3],1) . "%\r\n";

echo date("g:i a") . "\r\n";
echo date("D n/j/y");
?>