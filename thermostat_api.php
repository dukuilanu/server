<?php
$conn = mysqli_connect("localhost","root","Apik0r0s","therm");
$ext_conn = mysqli_connect("localhost","root","Apik0r0s","home");
if (isset($_GET["testing"])) {
  echo time();
}
if (isset($_GET["outSub"])) {
  $return = mysqli_query($ext_conn,"INSERT INTO extLog values('" . time() . "','" . $_GET["temp"] . "','" . $_GET["humidity"] . "','" . $_GET["pressure"] . "');");
}

//device checks in here.
if (isset($_GET["inSub"])) {
	//record current temperature from the device:
	$return = mysqli_query($conn,"UPDATE zones SET primary_sensor_current = '" . $_GET["temp"] . "' WHERE id = " . $_GET["id"] . ";");
	$return = mysqli_query($conn,"UPDATE zones SET updated = '" . time() . "' WHERE id = '" . $_GET["id"] . "';");
  
	if (isset($_GET["humidity"])) {
	$return = mysqli_query($conn,"UPDATE zones SET humidity = " . $_GET["humidity"] . " WHERE id = " . $_GET["id"] . ";");
	}

	//Server's response to the device starts here:
	$return = mysqli_query($conn,"SELECT time AS time, temp AS temp FROM settings WHERE zone = " . $_GET["id"] . " ORDER BY time ASC;");
	$now_time = date("Hi");
	$setting_times = array();
	$i = 0;
	while ($result = mysqli_fetch_array($return)){
		$setting_times[$i] = $result['time'];
		$i = $i + 1;
	}
	
	foreach($setting_times as $i) {
		if ($i < $now_time) {
			$setting_time = $i;
		}
	}
	
	if ($setting_time > 0) {
		$return = mysqli_query($conn,"SELECT time AS time, temp AS temp FROM settings WHERE zone = " . $_GET["id"] . " AND time = " . $setting_time . ";");
		$result = mysqli_fetch_array($return);
		$setting = $result['temp'];
	}
	
	else {
		$return = mysqli_query($conn,"SELECT time AS time, temp AS temp FROM settings WHERE zone = " . $_GET["id"] . " ORDER BY time DESC LIMIT 1;");
		$result = mysqli_fetch_array($return);
		$setting = $result['temp'];

	}
	echo "set:" . $setting;
}

//circulator device checks in for on/off info here:
if (isset($_GET["pumpStatus"])) {
	$return = mysqli_query($conn,"SELECT id AS id, primary_sensor_current AS temp FROM zones;");
	$now_time = date("Hi");
	$current_temps = array();
	
	while ($result = mysqli_fetch_array($return)){
		$current_temps[$result['id']] = $result['temp'];
	}
	
	foreach($current_temps as $this_id => $current){
		$return = mysqli_query($conn,"SELECT time AS time, temp AS temp FROM settings WHERE zone = " . $this_id . " ORDER BY time ASC;");
		$now_time = date("Hi");
		$setting_times = array();
		$i = 0;
		while ($result = mysqli_fetch_array($return)){
			$setting_times[$i] = $result['time'];
			$i = $i + 1;
		}
		
		foreach($setting_times as $i) {
			if ($i < $now_time) {
				$setting_time = $i;
			}
			
		}

		if ($setting_time != "") {
			$return = mysqli_query($conn,"SELECT time AS time, temp AS temp FROM settings WHERE zone = " . $this_id . " AND time = " . $setting_time . ";");
			$result = mysqli_fetch_array($return);
			$setting = $result['temp'];
		}
		
		else {
			$return = mysqli_query($conn,"SELECT time AS time, temp AS temp FROM settings WHERE zone = " . $this_id . "ORDER BY time DESC LIMIT 1;");
			$result = mysqli_fetch_array($return);
			$setting = $result['temp'];

		}
		
		echo $this_id . ":";
		
		if ($current < $setting + 1) {
			echo "1";
		}
		
		else {
			echo "0";
		}
		
	}
  
}


//Web site work is done here.
//Internal api call to trim the extLog table every 24 hours
if (isset($_GET["trim"])) {
  echo "DELETE FROM extLog WHERE date < '" . (time() - (24 * 60 * 60)) . "';";
  $return = mysqli_query($ext_conn,"DELETE FROM extLog WHERE date < '" . (time() - (24 * 60 * 60)) . "';");
}
//Report current temp:

//Report current setting
  //is it an override?
  
//Web user has an override:

//Report list of time zones
  //foreach their setting

//User changed setting for a time zone:

//User changed span of a time zone:


?>
