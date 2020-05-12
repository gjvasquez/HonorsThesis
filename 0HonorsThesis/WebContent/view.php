<?php
session_start();

if (isset($_SESSION['user'])) {
    echo "Currently logged in as: " . $_SESSION['user'];
}

if (isset($_SESSION['shoppingError'])) {
    $message = $_SESSION['shoppingError'];
    $_SESSION['shoppingError'] = NULL;
    echo "<script>alert('$message');</script>";
}

?>

<html>
<head>
<meta charset="ISO-8859-1">
<title>CS Problem Search</title>
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
	<br>
	<h1>&nbsp; CS Exam Creator/Browser</h1>
	<div class="informationHolder">
		<div class="information">
			With this website, you can view Computer Science questions that range
			from: <br> <br>
			<ul>
				<li>difficulty</li>
				<li>language</li>
				<li>estimated time of completion</li>
				<li>type of question</li>
			</ul>
		</div>
		<br> <br>
		<div class="information">Use the links at the top of the screen to
			navigate.</div>
		<br>
		<div class="information">
			*You <b>must</b> be logged in to use the Shopping Cart feature.
		</div>
	</div>


</body>


</html>