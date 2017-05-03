<html>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="scripts.js"></script>
</head>

<body>
  <div id="logo" style="position:absolute;left:25px;top:25px;width:250;height:175">
    <div style="position:absolute;top:0px;left:60px">
      <image src="/images/Command_logo.png" height="75%">
    </div>
  </div>

  <div id="securityDiv" class="section" style="top:200px;left:25px;width:250px;height:200px">
    SECURITY
    <div id="pic" class="subSection" style="top:60px;left:5%;width:90%;height:35px;" onclick="getPic()">
      VIEW
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
  
  <div id="env" class="section" style="top:25;left:325;width:650;height:700">
    EXTERNAL ANALYSIS
    
    <div id="radar" class="envElement" style="top:0px;left:25px;width:300;height:375">
      <div style="position:absolute;top:60px;left:0px;width:300px">
        <img src="weather/loop.gif" width="300" />
      </div>
    </div>
    
    <div id="cast" style="top:60px;left:335px">
      <?php
        $conn = mysqli_connect("localhost","root","Apik0r0s","home");
        $return = mysqli_query($conn,"SELECT * FROM extLog ORDER BY date DESC LIMIT 1;");
        $result = mysqli_fetch_array($return);
        echo '<span style="color:rgb(28,255,28)">' . date("H:i",$result[0]) . '<br /><br />HULL SENSOR:<br /></span>';
        echo "Temperature: " . $result[1] . "<br />Humidity: " . $result[3] . "<br /><br />";
        
        $forecast = simplexml_load_file("weather/weather.xml");
        echo '<span style="color:rgb(28,255,28)">PREDICTED:</span><br />Now: ' . $forecast->data[0]->parameters[0]->temperature[0]->value[0] . ", Next: ";
        echo $forecast->data[0]->parameters[0]->temperature[1]->value[0] . "<br />";
        echo $forecast->data[0]->{'time-layout'}[0]->{'start-valid-time'}[0]['period-name'] . ": ";
        echo $forecast->data[0]->parameters[0]->weather[0]->{'weather-conditions'}[0]['weather-summary'] . "<br />";
        echo $forecast->data[0]->{'time-layout'}[0]->{'start-valid-time'}[1]['period-name'] . ": ";
        echo $forecast->data[0]->parameters[0]->weather[0]->{'weather-conditions'}[1]['weather-summary'] . "<br /><br />";
      ?>
    </div>
    
    <div id="graph" style="position:absolute;top:400px;left:25px">
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
    
    <div id="upHeat" class="subSection" style="top:288px;left:5%;width:90%;height:80">
      OPERATIONS:
      <div id="uTemp" style="top:65%;width:100%;height:35%">
        <?php
          $return = mysqli_query($conn,"SELECT temp AS temp FROM thermostat where id = 2;");
          $result = mysqli_fetch_array($return);
          echo $result['temp'] . " F<br />";
        ?>
      </div>
    </div>
  </div>

</body>

</html>
