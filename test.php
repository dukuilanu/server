<?php
$conn = mysqli_connect( "localhost","root","Apik0r0s","home" );
$return = mysqli_query($conn,"select temp as temp from thermostat where id = '2'");
$array = mysqli_fetch_array($return);
$temp = $array['temp'];
echo $temp . "\n";
$headers = array("x-aio-key: 08f143e7a66aed7befef96dd5855bf33e8f6d530", "Content-Type: application/x-www-form-urlencoded");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://io.adafruit.com/api/feeds/604788/data.xml");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

$postarray = array(
"value" => $temp
);

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postarray));

$data = curl_exec($ch);
echo curl_error($ch);
curl_close($ch);
echo $data;

?>
