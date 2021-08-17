<html>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="scripts.js"></script>
</head>

<body>
  <div id="logo" style="position:absolute;left:65px;top:10px;width:250;height:175">
    <image src="/images/Command_logo.png" height="175px" width="175px">
  </div>
  
  <div id="secConsole">
    <image src="images/console.png" style="position:absolute;left:60px;top:25px;" onclick="secClick()" />
    <div class="subSection" id="refreshButton" style="left:60px;top:235;width:225px;height:35px" onclick="getPic()">
      REFRESH IMAGE
    </div>
    <div class="subSection" id="streamButton" style="left:60px;top:295;width:225px;height:35px">
      <a href='/stream'>STREAM</a>
    </div>
    <div class="subSection" id="lastPullId" style="left:350;top:85;width:225;height:70">
      LOADING...
    </div>
    <div class="subSection" id="lastEventId" style="left:600;top:85;width:225;height:70">
      LOADING...
    </div>
    <div id="lastPic" style="position:absolute;left:350px;top:235px;width:480px;height:320px">
      <image id='lastPicId' src='' width='480' height='320' />
    </div>
    <div id="secBottomBar" class="subSection" style="bottom:25px;left:5%;width:90%;height:35px" onclick="enable()">
      LOADING...
    </div>
  </div>
  
  <div id="securityDiv" class="section" style="top:200px;left:25px;width:250px;height:200px">
    SECURITY
    <div id="pic" class="subSection" style="top:60px;left:5%;width:90%;height:35px;" onclick="secClick()">
      CONSOLE
    </div>
    
    <div id="sec" class="subSection" style="top:129px;left:5%;width:90%;height:35px" onclick="enable()">
      ENGAGE
    </div>
  </div>
  
  <div id="statusDiv" class="section" style="top:425;left:25;width:250;height:300">
    SHIP STATUS
    <div id="vacHeader" class="subsection" style="top:60px;left:5%;width:90%;height:80" onclick="setVac()">
      VACUUM:
      <div id="vac" style="top:65%;width:100%;height:35%">
        loading...
      </div>
    </div>
    
    <div id="gDoor" class="subSection" style="top:174;left:5%;width:90%;height:80" >
      POD BAY 1:
      <div id="door" style="top:65%;width:100%;height:35%">
        loading...
      </div>
    </div>
  </div>
  
  <div id="env" class="section" style="top:25;left:325;width:650;height:850">
    CURRENT ORBIT: TAU CETI V
    
    <div id="radar" class="envElement" style="top:0px;left:25px;width:300;height:375">
      <div style="position:absolute;top:60px;left:0px;width:300px">
        <span style="color:rgb(28,255,28)">Stellar Activity:<br /></span>
        <img src="weather/space1.gif" width="300" />
      </div>
    </div>
    
    <div id="cast" style="top:60px;left:335px">
      <?php
        $conn = mysqli_connect("localhost","root","Apik0r0s","home");
        $return = mysqli_query($conn,"SELECT * FROM extLog ORDER BY date DESC LIMIT 1;");

        if (mysqli_num_rows($return) != 0) {
          $result = mysqli_fetch_array($return);
          echo '<span style="color:rgb(28,255,28)">' . date("M j H:i",$result[0]) . '<br /><br />HULL SENSOR:<br /></span>';
          echo "Temperature: " . $result[1] . "<br />Humidity: " . $result[3] . "<br /><br />";
        } else {
          echo '<span style="color:red">HULL SENSOR:<br /><i>Sensor Read Error!</i></span><br /><br /><br />';
        }

        $file = fopen("weather/spacecast_final.txt", "r");
        //Output lines until EOF is reached
        while(! feof($file)) {
          $line = fgets($file);
          echo $line;
        }

fclose($file);
        //$forecast = simplexml_load_file("weather/weather.xml");
        //echo '<span style="color:rgb(28,255,28)">PREDICTED:</span><br />Now: ' . $forecast->data[0]->parameters[0]->temperature[0]->value[0] . ", Next: ";
        //echo $forecast->data[0]->parameters[0]->temperature[1]->value[0] . "<br />";
        //echo $forecast->data[0]->{'time-layout'}[0]->{'start-valid-time'}[0]['period-name'] . ": ";
        //echo $forecast->data[0]->parameters[0]->weather[0]->{'weather-conditions'}[0]['weather-summary'] . "<br />";
        //echo $forecast->data[0]->{'time-layout'}[0]->{'start-valid-time'}[1]['period-name'] . ": ";
        //echo $forecast->data[0]->parameters[0]->weather[0]->{'weather-conditions'}[1]['weather-summary'] . "<br /><br />";
      ?>
    </div>
    
    <div id="graph" style="position:absolute;top:550px;left:25px">
      Planetary Surface Forecast:<br />
      <img src="weather/48_graph.png" width="600px" />
    </div>
    
  </div>
  
  <div id="therm" class="section" style="top:25;left:1025;width:250;height:700">
    ENVIRONMENTAL
    <div id="upHeat" class="subSection" style="top:60px;left:5%;width:90%;height:80">
      CREW QUARTERS:
      <div id="uTemp" style="top:65%;width:100%;height:35%">
        loading...
      </div>
    </div>
    
    <div id="downHeat" class="subSection" style="top:174px;left:5%;width:90%;height:80">
      RECREATION:
      <div id="dTemp" style="top:65%;width:100%;height:35%">
        loading...
      </div>
    </div>
    
    <div id="opsHeat" class="subSection" style="top:288px;left:5%;width:90%;height:80">
      OPERATIONS:
      <div id="opsTemp" style="top:65%;width:100%;height:35%">
        loading...
      </div>
    </div>
  </div>

</body>

</html>
