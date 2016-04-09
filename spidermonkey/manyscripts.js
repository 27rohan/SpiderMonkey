function category(str){
	var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
      	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            	document.getElementById("main").innerHTML = xmlhttp.responseText;
            }
		else{
			document.getElementById("main").innerHTML="<img src=\"loading-circle.gif\">";
		} 
      }
      xmlhttp.open("GET", "get_ca_body.php?q=" + str, true);
      xmlhttp.send();
}

function recommendbytag(id){
	var mfhid="mfh"+id;
	document.getElementById(mfhid).style.display = "block";
	var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
      	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById(mfhid).innerHTML = xmlhttp.responseText;
            }
		else{
			document.getElementById(mfhid).innerHTML="<img src=\"loading-circle.gif\">";
		} 
      }
      xmlhttp.open("GET", "recommendbytag.php?id="+id, true);
      xmlhttp.send();
}


function initialize(){
	var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
      	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            	document.getElementById("ad").innerHTML = xmlhttp.responseText;
            }
		else{
			document.getElementById("ad").innerHTML="<img src=\"loading-circle.gif\">";
		} 
      }
      xmlhttp.open("GET", "initialize.php", true);
      xmlhttp.send();
}


function logout(){
	window.location = "logout.php";
}

function login(){
	var username = document.forms["form1"]["username"].value;
	var pass = document.forms["form1"]["pass"].value;
	//Check input Fields Should not be blanks.
	if (pass == null || pass == '' || username == '') {
		alert("Fill All Fields");
		return false;
	}
	else {
		return true;
	}
}

function signup(){
	return signup_validate("pass");
	return signup_validate("email");
	return signup_validate("name");
	return signup_validate("business");
	return signup_validate("sport");
	return signup_validate("nation");
	return signup_validate("life_and_style");
	return signup_validate("sci_tech");
	return signup_validate("entertainment");
	var email=document.getElementById("email").value;
	var pass=document.getElementById("pass").value;
	var name=document.getElementById("name").value;
	var sport=document.getElementById("sport").value;
	var entertainment=document.getElementById("entertainment").value;
	var life_and_style=document.getElementById("life_and_style").value;
	var sci_tech=document.getElementById("sci_tech").value;
	var nation=document.getElementById("nation").value;
	var business=document.getElementById("business").value;
	var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
	var xmlhttp = new XMLHttpRequest();
      	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            	document.getElementById("output").innerHTML = xmlhttp.responseText;
            }
		else{
			document.getElementById("output").innerHTML="<img src=\"loading-circle.gif\">";
		} 
      }
      xmlhttp.open("POST", "signup.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var temp="&sport="+sport+"entertainment="+entertainment+"&life_and_style="+life_and_style+"&sci_tech="+sci_tech+"&nation="+nation+"&business="+business;    
	xmlhttp.send("email="+email+"&pass="+pass+"&name="+name+temp);
}

function signup_validate(id){
	var temp=document.getElementById(id).value;
	if(id=="pass"){
		if(temp=="" || temp==null){document.getElementById("ppass").innerHTML="cant be empty"; return false;}
		else if(temp.length<6){ document.getElementById("ppass").innerHTML="password is too small"; return false;}
		else {document.getElementById("ppass").innerHTML="<img scr='pic/correct.png'>"; return true; }
	}
	if(id=="sport"){
		if(temp>6) {document.getElementById("ppriority").innerHTML="not greater than 6"; return false;}
		else if(temp<0) {document.getElementById("ppriority").innerHTML="not lesser than 0"; return false;}
		else if(temp>0 && temp<=6){
		var v2=document.getElementById("entertainment").value;
		var v3=document.getElementById("life_and_style").value;
		var v4=document.getElementById("sci_tech").value;
		var v5=document.getElementById("nation").value;
		var v6=document.getElementById("business").value;
		if(v2==temp||v3==temp||v4==temp||v5==temp||v6==temp) {document.getElementById("ppriority").innerHTML="same value"; return false;}}
		else if(temp==0){document.getElementById("ppriority").innerHTML=""; return true;}
		else{document.getElementById("ppriority").innerHTML="only numerical value"; return false;}
	}
	if(id=="entertainment"){
		if(temp>6) {document.getElementById("ppriority").innerHTML="not greater than 6"; return false;}
		else if(temp<0) {document.getElementById("ppriority").innerHTML="not lesser than 0"; return false;}
		else if(temp>0 && temp<=6){
		var v2=document.getElementById("sport").value;
		var v3=document.getElementById("life_and_style").value;
		var v4=document.getElementById("sci_tech").value;
		var v5=document.getElementById("nation").value;
		var v6=document.getElementById("business").value;
		if(v2==temp||v3==temp||v4==temp||v5==temp||v6==temp) {document.getElementById("ppriority").innerHTML="same value"; return false;}}
		else if(temp==0){document.getElementById("ppriority").innerHTML=""; return true;}
		else{document.getElementById("ppriority").innerHTML="only numerical value"; return false;}
	}
        if(id=="life_and_style"){
		if(temp>6) {document.getElementById("ppriority").innerHTML="not greater than 6"; return false;}
		else if(temp<0) {document.getElementById("ppriority").innerHTML="not lesser than 0"; return false;}
		else if(temp>0 && temp<=6){
		var v2=document.getElementById("entertainment").value;
		var v3=document.getElementById("sport").value;
		var v4=document.getElementById("sci_tech").value;
		var v5=document.getElementById("nation").value;
		var v6=document.getElementById("business").value;
		if(v2==temp||v3==temp||v4==temp||v5==temp||v6==temp) {document.getElementById("ppriority").innerHTML="same value"; return false;}}
		else if(temp==0){document.getElementById("ppriority").innerHTML=""; return true;}
		else{document.getElementById("ppriority").innerHTML="only numerical value"; return false;}
	}
        if(id=="sci_tech"){
		if(temp>6) {document.getElementById("ppriority").innerHTML="not greater than 6"; return false;}
		else if(temp<0) {document.getElementById("ppriority").innerHTML="not lesser than 0"; return false;}
		else if(temp>0 && temp<=6){
		var v2=document.getElementById("entertainment").value;
		var v3=document.getElementById("life_and_style").value;
		var v4=document.getElementById("sport").value;
		var v5=document.getElementById("nation").value;
		var v6=document.getElementById("business").value;
		if(v2==temp||v3==temp||v4==temp||v5==temp||v6==temp) {document.getElementById("ppriority").innerHTML="same value"; return false;}}
		else if(temp==0){document.getElementById("ppriority").innerHTML=""; return true;}
		else{document.getElementById("ppriority").innerHTML="only numerical value"; return false;}
	}
        if(id=="nation"){
		if(temp>6) {document.getElementById("ppriority").innerHTML="not greater than 6"; return false;}
		else if(temp<0) {document.getElementById("ppriority").innerHTML="not lesser than 0"; return false;}
		else if(temp>0 && temp<=6){
		var v2=document.getElementById("entertainment").value;
		var v3=document.getElementById("life_and_style").value;
		var v4=document.getElementById("sci_tech").value;
		var v5=document.getElementById("sport").value;
		var v6=document.getElementById("business").value;
		if(v2==temp||v3==temp||v4==temp||v5==temp||v6==temp) {document.getElementById("ppriority").innerHTML="same value"; return false;}}
		else if(temp==0){document.getElementById("ppriority").innerHTML=""; return true;}
		else{document.getElementById("ppriority").innerHTML="only numerical value"; return false;}
	}
        if(id=="business"){
		if(temp>6) {document.getElementById("ppriority").innerHTML="not greater than 6"; return false;}
		else if(temp<0) {document.getElementById("ppriority").innerHTML="not lesser than 0"; return false;}
		else if(temp>0 && temp<=6){
		var v2=document.getElementById("entertainment").value;
		var v3=document.getElementById("life_and_style").value;
		var v4=document.getElementById("sci_tech").value;
		var v5=document.getElementById("nation").value;
		var v6=document.getElementById("sport").value;
		if(v2==temp||v3==temp||v4==temp||v5==temp||v6==temp) {document.getElementById("ppriority").innerHTML="same value"; return false;}}
		else if(temp==0){document.getElementById("ppriority").innerHTML=""; return true;}
		else{document.getElementById("ppriority").innerHTML="only numerical value"; return false;}
	}
	if(id=="name"){
		if(temp.length==0){document.getElementById("pname").innerHTML="*"; return false;}
		var xmlhttp = new XMLHttpRequest();
      	xmlhttp.onreadystatechange = function() {
      		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            		document.getElementById("pname").innerHTML = xmlhttp.responseText;
	            }
			else{
				document.getElementById("pname").innerHTML="<img src=\"loading-circle.gif\">";
			} 
      	}
	      xmlhttp.open("GET", "signupvalidate.php?resp=name&name="+temp, true);
      	xmlhttp.send();
	}
	if(id=="email"){
		if(temp.length==0){document.getElementById("pemail").innerHTML="*"; return false;}
		var xmlhttp = new XMLHttpRequest();
      	xmlhttp.onreadystatechange = function() {
      		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            		document.getElementById("pemail").innerHTML = xmlhttp.responseText;
	            }
			else{
				document.getElementById("pemail").innerHTML="<img src=\"loading-circle.gif\">";
			} 
      	}
	      xmlhttp.open("GET", "signupvalidate.php?resp=email&email="+temp, true);
      	xmlhttp.send();
	}
}

function changead(adnoid){
	var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
      	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            	document.getElementById(adnoid).innerHTML = xmlhttp.responseText;
            }
		else{
			document.getElementById(adnoid).innerHTML="<img src=\"loading-circle.gif\">";
		} 
      }
      xmlhttp.open("GET", "changead.php?adnoid=" + adnoid, true);
      xmlhttp.send();	
}	
