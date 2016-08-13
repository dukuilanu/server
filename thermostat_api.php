<?php
$conn = mysqli_connect("localhost","root","Apik0r0s","home");

//first handle the outside thermostat
if (isset ($_GET["outSub"])) {
	$return = mysqli_query($conn, "INSERT INTO extLog VALUES (" . time() . ",'" . $_GET['outTemp'] . "',NULL,'" . $_GET['outHumidity'] . "');");
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

		if ($result["temp"] == "") {
		  $return = mysqli_query($conn,"SELECT id AS id FROM " . $sched . " WHERE endTime <= 2400 ORDER BY endTime DESC;");
		  $result = mysqli_fetch_array($return);
		}
		
		$return = mysqli_query($conn,"UPDATE thermostat SET override = " . $_GET["override"] . ", overrideFrom = " . $result["id"] . " WHERE id = " . $_GET["id"] . ";");
	}
	
	//Server's response to the device starts here:

	/* Get the scheduled temperature:
	
	$return = mysqli_query($conn,"SELECT endTime AS endTime, temp AS temp FROM " . $sched . " WHERE endTime <= " . date("Gi") . " ORDER BY endTime DESC;");
	$result = mysqli_fetch_array($return);

	if ($result["temp"] == "") {
	  $return = mysqli_query($conn,"SELECT id AS id, endTime AS endTime, temp AS temp FROM " . $sched . " WHERE endTime <= 2400 ORDER BY endTime DESC;");
	  $result = mysqli_fetch_array($return);
	}
	
	$currentId = $result["id"];
	$setting = $result["temp"];
	*/
	//next check if there was an override reported
	$return = mysqli_query($conn,"SELECT override AS override, overrideFrom AS time FROM thermostat WHERE id = " . $_GET["id"] . ";");
	$result = mysqli_fetch_array($return);
	if ($result["override"] != '') {
		//check to see if the override ends, i.e. we are now in a new time zone:
		//if ($result["time"] == $currentId) {
			$setting = $result["override"];
		//}
		//else {
		//	$result = mysqli_query($conn, "UPDATE thermostat SET override = NULL, overrideFrom = NULL where id = " . $_GET["id"]);
		//}
	}
	
	echo "set:" . $setting;
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
