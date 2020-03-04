<?php
session_start();
?>

<html>
<head>
<meta charset="ISO-8859-1">
<title>Register</title>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>
<h3>Register a new Account</h3>

<div id="info">
<form onsubmit="addUser();return false">
	Username: &nbsp; <input id="username">
	<br>
	Password: &nbsp; <input id="password">
	<br>
	<br>
	<input type="submit" value="Register">
</form>
</div>
<br>
<br>
<div id="toChange"></div>

</body>

<script>
function addUser() {
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	
	var div = document.getElementById("toChange");
    var ajax = new XMLHttpRequest();
    	ajax.open("GET","controller.php?action=register&username=" + username + "&password=" + password, true); 
    	ajax.send();
    	ajax.onreadystatechange = function(){
    		if (ajax.readyState == 4 && ajax.status == 200) {
    			var message = ajax.responseText; 
    			div.innerHTML += message;	
    			username.value = "";
    		    password.value = "";	
    		}
    	};
}

</script>
</html>