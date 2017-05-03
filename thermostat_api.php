<?php
$conn = mysqli_connect("localhost","root","Apik0r0s","home");

//first handle the outside thermostat
if (isset ($_GET["outSub"])) {
	$return = mysqli_query($conn, "INSERT INTO extLog VALUES (" . time() . "," . $_GET['outTemp'] . " + 1.5,NULL,'" . $_GET['outHumidity'] . "');");
	echo "SUBMITTED";
}

//device checks in here.
if (isset($_GET["inSub"])) {
  //First find the floor the device is on
	$return = mysqli_query($conn,"SELECT floor AS floor FROM thermostat WHERE id = " . $_GET["id"] . ";");
	$result = mysqli_fetch_array($return);
	if ($result["floor"] == 2) {
		$sched = "upSched";
	}
	else {
		$sched = "downSched";
	}
	//record current temperature from the device:
	$return = mysqli_query($conn,"UPDATE thermostat SET temp = " . $_GET["temp"] . "WHERE id = " . $_GET["id"] . ";");
  
  if (isset($_GET["humidity"])) {
    $return = mysqli_query($conn,"UPDATE thermostat SET humi = " . $_GET["humidity"] . "WHERE id = " . $_GET["id"] . ";");
  }
  
	//If the device has a new override value to report, insert it here:
	if (isset($_GET["override"])) {
		//first get our current time zone
		$return = mysqli_query($conn,"SELECT id AS id FROM " . $sched . " WHERE endTime <= " . date("Gi") . " ORDER BY endTime DESC;");
		$result = mysqli_fetch_array($return);

		if ($result["id"] == "") {
		  $return = mysqli_query($conn,"SELECT id AS id FROM " . $sched . " WHERE endTime <= 2400 ORDER BY endTime DESC;");
		  $result = mysqli_fetch_array($return);
		}
		
		$return = mysqli_query($conn,"UPDATE thermostat SET override = " . $_GET["override"] . ", overrideFrom = " . $result["id"] . " WHERE id = " . $_GET["id"] . ";");
	}
	
	//Server's response to the device starts here:
	$return = mysqli_query($conn,"SELECT override AS override, overrideFrom AS time FROM thermostat WHERE id = " . $_GET["id"] . ";");
	$result = mysqli_fetch_array($return);
	if ($result["override"] != '') {
			$setting = $result["override"];
	}
	
	echo "set:" . $setting;
}

//circulator device checks in for on/off info here:
if (isset($_GET["pumpStatus"])) {
  $return = mysqli_query($conn,"SELECT temp AS temp, override AS override FROM thermostat WHERE id = 1;");
  $result = mysqli_fetch_array($return);
  $uptemp = $result["temp"];
  $upoverride = $result["override"];
  $return = mysqli_query($conn,"SELECT state AS state FROM status WHERE name = 'uHeat';");
  $result = mysqli_fetch_array($return);
  $upstate = $result["state"];
  
  if ($upstate == 0) {
    if ($uptemp < $upoverride - 1){
      $return = mysqli_query($conn,"UPDATE status SET state = 1 WHERE name = 'uHeat'");
      echo "up:1";
    } else {
      echo "up:0";
    }
  }
  
  if ($upstate == 1) {
    if ($uptemp > $upoverride + 1) {
      $return = mysqli_query($conn,"UPDATE status SET state = 0 WHERE name = 'uHeat'");
      echo "up:0";
    } else {
      echo "up:1";
    }
  }
  
  $return = mysqli_query($conn,"SELECT temp AS temp, override AS override FROM thermostat WHERE id = 3;");
  $result = mysqli_fetch_array($return);
  $downtemp = $result["temp"];
  $downoverride = $result["override"];
  $return = mysqli_query($conn,"SELECT state AS state FROM status WHERE name = 'dHeat';");
  $result = mysqli_fetch_array($return);
  $downstate = $result["state"];
  
  if ($downstate == 0) {
    if ($downtemp < $downoverride - 1){
      $return = mysqli_query($conn,"UPDATE status SET state = 1 WHERE name = 'dHeat'");
      echo "down:1";
    } else {
      echo "down:0";
    }
  }
  
  if ($downstate == 1) {
    if ($downtemp > $downoverride + 1) {
      $return = mysqli_query($conn,"UPDATE status SET state = 0 WHERE name = 'dHeat'");
      echo "down:0";
    } else {
      echo "down:1";
    }
  }
}


//Web site work is done here.
//Report current temp:

//Report current setting
  //is it an override?
  
//Web user has an override:

//Report list of time zones
  //foreach their setting

//User changed setting for a time zone:

//User changed span of a time zone:


?>
