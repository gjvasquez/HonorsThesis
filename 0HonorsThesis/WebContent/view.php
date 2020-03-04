<?php

session_start();

if (isset ($_SESSION['user'])) {
    echo "Currently logged in as: " . $_SESSION['user'];
    
}

?>

<html>
<head>
<meta charset="ISO-8859-1">
<title>CS Problem Search</title>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>

<div class = "heading">
	<a href="shoppingCart.php">Shopping Cart</a>
	&nbsp; &nbsp; &nbsp;
	<a href="search.php">Search</a>
	&nbsp; &nbsp; &nbsp;
	<a href="add.php">Add your own questions</a>
	&nbsp; &nbsp; &nbsp;
	<a href="login.php">Login</a>
	&nbsp; &nbsp; &nbsp;
	<a href="register.php">Sign up</a>
</div>
<br>
<h1>Home Page</h1>


</body>


</html>