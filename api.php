

<?php
$conn = mysqli_connect("localhost","root","Apik0r0s","home");
$conn_therm = mysqli_connect("localhost","root","Apik0r0s","therm");

//Here, we just echo out the time for the thermostats
if (isset($_GET['date'])) {
  //return the current time
  echo date("g:i a");
}

//Here we will store/ fetch the alarm setting for the bedroom clock.
if (isset($_GET['alarm'])) {
  if (isset($_GET['subbing'])) {
    //store the new alarm setting
    $return = mysqli_query($conn,"UPDATE status SET queued = " . $_GET['subbing'] . " where name = 'alarm';");
  }
  
  if (isset($_GET['switch'])) {
    $return = mysqli_query($conn,"UPDATE status SET state = " . $_GET['switch'] . " where name = 'alarm';");
  }
  $return = mysqli_query($conn,"SELECT queued AS alarm, state as status FROM status WHERE name = 'alarm';");
  $row = mysqli_fetch_array($return);
  echo "ALARM\r" . $row['alarm'] . "\r" . $row['status'];
 
}

//Here are the services for the devices to grab queued commands
//and update their status accordingly
if (isset($_GET['device_api_pushing'])) {
  if ($_GET["vac"] == "1") {
	//update the db for vacuum on
	$reset = mysqli_query($conn,"UPDATE status SET state = TRUE where name = 'ceVac';");
  }
  
  if ($_GET["vac"] == "0") {
	//update the db for vacuum off
	$reset = mysqli_query($conn,"UPDATE status SET state = FALSE where name = 'ceVac';");
  }
  
    if ($_GET["door"] == "1") {
	//update the db for door up
	$reset = mysqli_query($conn,"UPDATE status SET state = TRUE where name = 'gDoor';");
  }
  
  if ($_GET["door"] == "0") {
	//update the db for door down
	$reset = mysqli_query($conn,"UPDATE status SET state = FALSE where name = 'gDoor';");
  }
  echo('OK');
}

if (isset($_GET['device_api_pulling'])) {
  //we return from the DB entry
  $return = mysqli_query($conn,"update status set updated = " . time() . " WHERE name = 'gDoor'");
  $return = mysqli_query($conn,"SELECT name AS text FROM status WHERE queued = TRUE;");
  
  if (mysqli_num_rows($return) == 0) {
	echo "NONE";
  }
  
  else {
	  $row = mysqli_fetch_array($return);
	  echo $row['text'];
	  $reset = mysqli_query($conn,"UPDATE status SET queued = FALSE WHERE name = '" . $row['text'] . "';");
  }
  
}

//Here is the api stuff for the security device
if (isset($_GET['sec'])) {
  if (isset($_GET['pic'])) {
    $return = mysqli_query($conn,"UPDATE security SET queued = TRUE WHERE name = 'secPic';");
    $return = mysqli_query($conn,"UPDATE security SET updated = " . time() . " WHERE name = 'secPic'");
    echo "pic command initiated";
  }
  
  if (isset($_GET['getLatestPic'])) {
    $return = mysqli_query($conn,"SELECT lastPic FROM security WHERE name = 'secPic'");
    $row = mysqli_fetch_array($return);
    echo $row[0] . ".jpg";
  }
  
  if (isset($_GET['newPic'])) {
    $return = mysqli_query($conn,"UPDATE security SET lastPic = " . $_GET['picTime'] . " WHERE name = 'secPic'");
  }
  
  if (isset($_GET['pulling'])) {
    $return = mysqli_query($conn,"UPDATE security SET updated = " . time() . " WHERE name = 'sec'");
    $return = mysqli_query($conn,"SELECT queued FROM security WHERE name = 'secPic'");
    $row = mysqli_fetch_array($return);
    if ($row['0'] == 1) {
      echo "takePic\r\n";
      $return = mysqli_query($conn,"UPDATE security SET queued = 0 WHERE name='secPic'");
    }

    $return = mysqli_query($conn,"SELECT queued FROM security WHERE name = 'sec'");
    $row = mysqli_fetch_array($return);
    if ($row['0'] == 1) {
      echo "enable\r\n";
    }
    
    else {
      echo "disable\r\n";
    }
  }
  
  if (isset($_GET['lastPull'])) {
    $return = mysqli_query($conn,"SELECT updated FROM security WHERE name = 'sec'");
    $row = mysqli_fetch_array($return);
    echo date("H:i M/j",$row[0]);
  }
  
    if (isset($_GET['lastEvent'])) {
    $return = mysqli_query($conn,"SELECT updated FROM security WHERE name = 'secEvent'");
    $row = mysqli_fetch_array($return);
    echo date("H:i M/j",$row[0]);
  }
  
  if (isset($_GET['event'])) {
    if ($_GET['event'] == "started") {
      $return = mysqli_query($conn,"UPDATE security SET state = 1, updated = " . time() . " WHERE name = 'sec' OR name = 'secEvent'");
    }
    
    if ($_GET['event'] == "stopped") {
      $return = mysqli_query($conn,"UPDATE security SET state = 0 WHERE name = 'sec'");
    }
  }
  
  if (isset($_GET['enable'])) {
    $return = mysqli_query($conn,"SELECT queued FROM security WHERE name = 'sec'");
    $row = mysqli_fetch_array($return);
    if ($row['0'] == 1) {
      $return = mysqli_query($conn,"UPDATE security SET queued = 0 WHERE name = 'sec'");
      echo "0";
    }
    
    else {
      $return = mysqli_query($conn,"UPDATE security SET queued = 1 WHERE name = 'sec'");
      echo "1";
    }
  }
  
  if (isset($_GET['check'])) {
    $return = mysqli_query($conn,"SELECT queued FROM security WHERE name = 'sec'");
    $row = mysqli_fetch_array($return);
    echo $row['0'];
  }

}

//These are services for the web page
//here, we queue anything selected by the website
if (isset($_GET['web_api_subbed'])) {
  //we queue the relevant DB entry for the device selected
  $return = mysqli_query($conn,"UPDATE status SET queued = TRUE where name = '" . $_GET['return'] . "';");
}

if (!isset($_GET['device_api_pulling']) && !isset($GET_['device_api_pushing']) && !isset($_GET['date'])) {
	if (isset($_GET['query'])) {
		//find out what was queried and issue a one line text response
		switch($_GET['query']) {
			case "doorState":
				$return = mysqli_query($conn,"SELECT state AS state FROM status WHERE name = 'gDoor';");
				$row = mysqli_fetch_array($return);
				echo $row['state'];
				break;
			case "vacState":
				$return = mysqli_query($conn,"SELECT state AS state, queued AS queued FROM status WHERE name = 'ceVac';");
				$row = mysqli_fetch_array($return);
				echo $row['state'] . $row['queued'];
				break;
			case "temp":
				$return = mysqli_query($conn_therm,"SELECT ROUND(primary_sensor_current, 2) AS state, ROUND(humidity, 2) AS hum, updated AS updated FROM zones WHERE id = '" . $_GET["zone"] . "';");
				$row = mysqli_fetch_array($return);
				echo $row['state'] . " F, " . $row['hum'] . " %<br />" . date("M j g:i a", $row['updated']);
				break;
			case "dHeat":
				$return = mysqli_query($conn_therm,"SELECT primary_sensor_current AS state FROM zones WHERE id = '2';");
				$row = mysqli_fetch_array($return);
				echo $row['state'];
				break;
		}
	}
}

?>

