

<?php
$conn = mysqli_connect("localhost","root","Apik0r0s","home");

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
  $return = mysqli_query($conn,"update status set updated = " . time() . " where name = 'gDoor'");
  $return = mysqli_query($conn,"SELECT name AS text FROM status WHERE queued = TRUE;");
  
  if (mysqli_num_rows($return) == 0) {
	echo "NONE";
  }
  
  else {
	  $row = mysqli_fetch_array($return);
	  echo $row['text'];
	  $reset = mysqli_query($conn,"UPDATE status SET queued = FALSE where name = '" . $row['text'] . "';");

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
				$return = mysqli_query($conn,"SELECT state AS state FROM status WHERE name = 'ceVac';");
				$row = mysqli_fetch_array($return);
				echo $row['state'];
				break;
			case "uHeat":
				$return = mysqli_query($conn,"SELECT override AS state FROM thermostat WHERE id = '2';");
				$row = mysqli_fetch_array($return);
				echo $row['state'];
				break;
			case "dHeat":
				$return = mysqli_query($conn,"SELECT queued AS state FROM status WHERE name = 'dHeat';");
				$row = mysqli_fetch_array($return);
				echo $row['state'];
				//$return = mysqli_query($conn,"UPDATE status SET state = " . $_GET["temp"] . " WHERE name = 'dHeat';");
				break;
		}
	}
}

?>

