<?php
$forecast = simplexml_load_file("weather/weather.xml");
echo " " . $forecast->data[0]->{'time-layout'}[0]->{'start-valid-time'}[0]['period-name'] . ":
";
echo " " . substr($forecast->data[0]->parameters[0]->weather[0]->{'weather-conditions'}[0]['weather-summary'],0,20) . "

";
echo " " . $forecast->data[0]->{'time-layout'}[0]->{'start-valid-time'}[1]['period-name'] . ":
";
echo " " . substr($forecast->data[0]->parameters[0]->weather[0]->{'weather-conditions'}[1]['weather-summary'],0,20) . "

";
echo " " . $forecast->data[0]->{'time-layout'}[0]->{'start-valid-time'}[2]['period-name'] . ":
";
echo " " . substr($forecast->data[0]->parameters[0]->weather[0]->{'weather-conditions'}[2]['weather-summary'],0,20);

?>