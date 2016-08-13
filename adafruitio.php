<?php?
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/");
curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
$output = curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);

echo $output;

<?>