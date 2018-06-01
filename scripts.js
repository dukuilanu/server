var uHeat = 0;
var dHeat = 0;

//This is the xhttp object for gDoor
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
  if (xhttp.readyState == 4 && xhttp.status == 200) {
    var response = xhttp.responseText;
    if (response.charAt(4) == "0") {
    document.getElementById("door").innerHTML = "LATCHED";
    document.getElementById("door").style.backgroundColor = "rgb(28,255,28)";
    }
    
    if (response.charAt(4) == "1") {
    document.getElementById("door").innerHTML = "Door is Up";
    document.getElementById("door").style.backgroundColor = "red";
    }
  }
};

//This is the xhttp object for ceVac
var xhttp2 = new XMLHttpRequest();
xhttp2.onreadystatechange = function() {
  if (xhttp2.readyState == 4 && xhttp2.status == 200) {
    var response = xhttp2.responseText;
    if (response.charAt(5) == "1") {
      document.getElementById("vac").style.backgroundColor = "yellow";
      document.getElementById("vac").innerHTML = "ENGAGING...";
    }
    else {
      if (response.charAt(4) == "0") {
      document.getElementById("vac").innerHTML = "DISENGAGED";
      document.getElementById("vac").style.backgroundColor = "rgb(28,255,28)";
      }
      
      if (response.charAt(4) == "1") {
      document.getElementById("vac").innerHTML = "ENGAGED";
      document.getElementById("vac").style.backgroundColor = "red";
      }
    }
  }
};

//This is the xhttp object for uTemp
var xhttp3 = new XMLHttpRequest();
xhttp3.onreadystatechange = function() {
  if (xhttp3.readyState == 4 && xhttp3.status == 200) {
    uHeat = xhttp3.responseText;
    document.getElementById("uTemp").innerHTML = uHeat + " F";
  }
};

//This is the xhttp object for dTemp
var xhttp4 = new XMLHttpRequest();
xhttp4.onreadystatechange = function() {
  if (xhttp4.readyState == 4 && xhttp4.status == 200) {
    dHeat = xhttp4.responseText;
    document.getElementById("dTemp").innerHTML = dHeat + " F";
  }
};

function getUpTherm() {
  xhttp3.open("GET", "api.php?query=uHeat", true);
  xhttp3.send();
}

function getDownTherm() {
  xhttp4.open("GET", "api.php?query=dHeat", true);
  xhttp4.send();
}

function getDoor() {
  xhttp.open("GET", "api.php?query=doorState", true);
  xhttp.send();
}

function getVac() {
  xhttp2.open("GET", "api.php?query=vacState", true);
  xhttp2.send();
}

function setVac() {
	var xhttp2 = new XMLHttpRequest();
	xhttp2.open("GET", "api.php?web_api_subbed=true&return=ceVac", true);
	xhttp2.send();
  document.getElementById("vac").style.backgroundColor = "yellow";
  document.getElementById("vac").innerHTML = "Waiting for device...";
};

function getPic() {
	var xhttp2 = new XMLHttpRequest();
	xhttp2.open("GET", "api.php?sec=true&pic=true", true);
	xhttp2.send();
};

function enable() {
	var xhttp2 = new XMLHttpRequest();
	xhttp2.open("GET", "api.php?sec=true&enable=on", true);
	xhttp2.send();
};

setInterval(getVac,1000);
setInterval(getDoor,1000);
setInterval(getUpTherm,2000);
setInterval(getDownTherm,2000);
