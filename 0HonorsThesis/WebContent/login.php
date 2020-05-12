<?php
session_start();
?>

<html>
<head>
<meta charset="ISO-8859-1">
<title>Login</title>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>

	<div class="heading">
		<a href="view.php">Home</a> &nbsp; &nbsp; &nbsp; 
		<a href="shoppingCart.php">Shopping Cart</a> &nbsp; &nbsp; &nbsp; 
		<a href="search.php">Search</a> &nbsp; &nbsp; &nbsp; 
		<a href="add.php">Add your own questions</a> &nbsp; &nbsp; &nbsp; 
		<a href="login.php">Login</a>&nbsp; &nbsp; &nbsp;
		<a href="register.php">Sign up</a> &nbsp; &nbsp; &nbsp; 
	</div>
	<h3 class="label">Login to an existing Account</h3>

	<div class="usernames">
		<div id="info">
			<form onsubmit="getUser();return false">
				Username: &nbsp; <input id="username"> <br> Password: &nbsp; <input
					type="password" id="password"> <br> <br> <input type="submit"
					value="Login">
			</form>
		</div>
	</div>
	<br>
	<br>
	<div id="toChange"></div>

</body>

<script>
function getUser() {
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	var div = document.getElementById("toChange");
    var ajax = new XMLHttpRequest();
    	ajax.open("GET","controller.php?action=login&username=" + username + "&password=" + password, true); 
    	ajax.send();
    
    	ajax.onreadystatechange = function() {
    		if (ajax.readyState == 4 && ajax.status == 200) {
    			var message = ajax.responseText; 
    			div.innerHTML += message;
    			console.log(message);
    			if (message.localeCompare("Successfully logged in") == 0) {
    				location.href='view.php';
    			}	
    			username.value = "";
    		    password.value = "";	
    		}
    	};
}

</script>
</html>