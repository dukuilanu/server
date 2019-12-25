var uHeat = 0;
var dHeat = 0;
var opsHeat = 0;
var lastPicUrl = "";
var firstRun = 1;
var secMode = 0;
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
    document.getElementById("uTemp").innerHTML = uHeat;
  }
};

//This is the xhttp object for dTemp
var xhttp4 = new XMLHttpRequest();
xhttp4.onreadystatechange = function() {
  if (xhttp4.readyState == 4 && xhttp4.status == 200) {
    dHeat = xhttp4.responseText;
    document.getElementById("dTemp").innerHTML = dHeat;
  }
};

var xhttp5 = new XMLHttpRequest();
xhttp5.onreadystatechange = function() {
  if (xhttp5.readyState == 4 && xhttp5.status == 200) {
    opsHeat = xhttp5.responseText;
    document.getElementById("opsTemp").innerHTML = opsHeat;
  }
};

function getUpTherm() {
  xhttp3.open("GET", "api.php?query=temp&zone=1", true);
  xhttp3.send();
}

function getDownTherm() {
  xhttp4.open("GET", "api.php?query=temp&zone=2", true);
  xhttp4.send();
}

function getOpsTherm() {
  xhttp5.open("GET", "api.php?query=temp&zone=3", true);
  xhttp5.send();
}

function getDoor() {
  xhttp.open("GET", "api.php?query=doorState", true);
  xhttp.send();
}

function getVac() {
  xhttp2.open("GET", "api.php?query=vacState", true);
  xhttp2.send();
  if (firstRun == 1) {
    getSecStatus();
    firstRun = 0;
  }
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
  document.getElementById("refreshButton").innerHTML = "REFRESHING...";
  document.getElementById("refreshButton").style.backgroundColor = "yellow";
  setTimeout(refreshImage,10000);
};

function refreshImage() {
  var xhttp2 = new XMLHttpRequest();
  xhttp2.open("GET", "api.php?sec=true&updatePic=true", true);
  xhttp2.onreadystatechange = function() {
    if (xhttp2.readyState == 4 && xhttp2.status == 200) {
      var response = xhttp2.responseText;
      document.getElementById("lastPicId").src = "/photo/" + response;
      document.getElementById("refreshButton").innerHTML = "REFRESH IMAGE";
      document.getElementById("refreshButton").style.backgroundColor = "rgb(28,255,28)";
    }
  }
  xhttp2.send();
}

function updateLastSecPull() {
  var xhttp2 = new XMLHttpRequest();
  xhttp2.open("GET", "api.php?sec=true&lastPull=true", true);
  xhttp2.onreadystatechange = function() {
    if (xhttp2.readyState == 4 && xhttp2.status == 200) {
      var response = xhttp2.responseText;
      document.getElementById("lastPullId").innerHTML = "SYSTEM CHECK:<br />" + response;
    }
  }
  xhttp2.send();
}

function updateLastSecEvent() {
  var xhttp2 = new XMLHttpRequest();
  xhttp2.open("GET", "api.php?sec=true&lastEvent=true", true);
  xhttp2.onreadystatechange = function() {
    if (xhttp2.readyState == 4 && xhttp2.status == 200) {
      var response = xhttp2.responseText;
      document.getElementById("lastEventId").innerHTML = "LAST ALARM:<br />" + response;
    }
  }
  xhttp2.send();
}

function secClick() {
  if (secMode == 0) {
    document.getElementById("secConsole").style.visibility = "visible";
    document.getElementById("secConsole").style.zIndex="10";
    secMode = 1;
  }
  else {
    document.getElementById("secConsole").style.visibility = "hidden";
    document.getElementById("secConsole").style.zIndex="-1";
    secMode = 0;
  }
  getSecStatus();
};

function enable() {
	var xhttp2 = new XMLHttpRequest();
	xhttp2.open("GET", "api.php?sec=true&enable=on", true);
  xhttp2.onreadystatechange = function() {
    if (xhttp2.readyState == 4 && xhttp2.status == 200) {
      var response = xhttp2.responseText;
      if (response.charAt(4) == "0") {
        document.getElementById("secBottomBar").innerHTML = "ENGAGE";
        document.getElementById("sec").innerHTML = "ENGAGE";
        document.getElementById("secBottomBar").style.backgroundColor = "rgb(28,255,28)";
        document.getElementById("sec").style.backgroundColor = "rgb(28,255,28)"
      }
      if (response.charAt(4) == "1") {
        document.getElementById("secBottomBar").innerHTML = "DISENGAGE";
        document.getElementById("sec").innerHTML = "DISENGAGE";
        document.getElementById("secBottomBar").style.backgroundColor = "yellow";
        document.getElementById("sec").style.backgroundColor = "yellow";
      }
    }
  }
	xhttp2.send();
};

function getSecStatus() {
  var xhttp2 = new XMLHttpRequest();
	xhttp2.open("GET", "api.php?sec=true&check=true", true);
  xhttp2.onreadystatechange = function() {
    if (xhttp2.readyState == 4 && xhttp2.status == 200) {
      var response = xhttp2.responseText;
      if (response.charAt(4) == "0") {
        document.getElementById("secBottomBar").innerHTML = "ENGAGE";
        document.getElementById("sec").innerHTML = "ENGAGE";
        document.getElementById("secBottomBar").style.backgroundColor = "rgb(28,255,28)low";
        document.getElementById("sec").style.backgroundColor = "rgb(28,255,28)"
      }
      if (response.charAt(4) == "1") {
        document.getElementById("secBottomBar").innerHTML = "DISENGAGE";
        document.getElementById("sec").innerHTML = "DISENGAGE";
        document.getElementById("secBottomBar").style.backgroundColor = "yellow";
        document.getElementById("sec").style.backgroundColor = "yellow";
      }
    }
  }
	xhttp2.send();
};

function getLatestPic() {
  var xhttp2 = new XMLHttpRequest();
  xhttp2.open("GET", "api.php?sec=true&getLatestPic=true", true);
  xhttp2.onreadystatechange = function() {
    if (xhttp2.readyState == 4 && xhttp2.status == 200) {
      var response = xhttp2.responseText;
      document.getElementById("lastPicId").src = "/photo/" + response;
    }
  }
  xhttp2.send();
}

setInterval(getVac,1010);
setInterval(getDoor,1000);
setInterval(getUpTherm,2010);
setInterval(getDownTherm,2000);
setInterval(getOpsTherm,1900);
setInterval(updateLastSecPull,5010);
setInterval(updateLastSecEvent,5000);
setInterval(getLatestPic,1020);
