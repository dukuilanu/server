<?php
$conn = mysqli_connect( "localhost","root","Apik0r0s","home" );
$return = mysqli_query($conn,"select updated as updated from status where name = 'gDoor'");
$array = mysqli_fetch_array($return);
$connecting = 0;
if ($array['updated'] + 300 < time()) {
  echo "NOT connecting!\n";
  $connecting = 0;
} else {
  echo "Connecting\n";
  $connecting = 1;
}

$headers = array("x-aio-key: 08f143e7a66aed7befef96dd5855bf33e8f6d530", "Content-Type: application/x-www-form-urlencoded");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://io.adafruit.com/api/groups/errans/send.xml?garage-status=" . $connecting);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
echo curl_error($ch);
curl_close($ch);
echo $data;

$return = mysqli_query($conn,"select date as updated from extLog order by date desc limit 1");
$array = mysqli_fetch_array($return);
$connecting = 0;
if ($array['updated'] + 600 < time()) {
  echo "NOT connecting!\n";
  $connecting = 0;
} else {
  echo "Connecting\n";
  $connecting = 1;
}

$headers = array("x-aio-key: 08f143e7a66aed7befef96dd5855bf33e8f6d530", "Content-Type: application/x-www-form-urlencoded");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://io.adafruit.com/api/groups/errans/send.xml?outside-status=" . $connecting);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
echo curl_error($ch);
curl_close($ch);
echo $data;


?>
