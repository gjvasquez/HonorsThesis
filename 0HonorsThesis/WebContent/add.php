<?php

session_start();

?>

<html>
<head>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({selector:'textarea'});</script>
<meta charset="ISO-8859-1">
<title>Add a Question</title>
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
	
<h3 class="label">Add a Question to the Database</h3>
<div class="label">This supports markdown.</div>

<div class="information">
    <form onsubmit="add()">
    	Title: 
    	<br>
      	<br><input id="title" class="input" type="text">
    	<br>
    	Question: 
    	<br><textarea id="question"></textarea>
    	<br>
    	Solution: 
    	<br><textarea id="solution"></textarea>
    	<br>
    	Hint: 
    	<br><input id="hint" class="input" type="text">
    	<br>
    	Language: &nbsp; &nbsp;
    	<select id="language">
    	  <option value="python" selected = "selected">Python</option>
    	  <option value="c">C</option>
    	  <option value="java">Java</option>
    	  <option value="html">HTML</option>
    	</select>
    	<br>
    	Difficulty: &nbsp; &nbsp;
    	<select id="difficulty">
    	  <option value="1" selected = "selected">1</option>
    	  <option value="2">2</option>
    	  <option value="3">3</option>
    	  <option value="4">4</option>
    	  <option value="5">5</option>
    	</select>
    	<br>
    	Estimated time: &nbsp; &nbsp;
    	<select id="time">
    	  <option value="10" selected = "selected">10</option>
    	  <option value="20">20</option>
    	  <option value="30">30</option>
    	  <option value="50">50</option>
    	</select>
    	<br>
    	Category: &nbsp; &nbsp;
    	<select id="category">
    	  <option value="fib" selected = "selected">Fill In the Blank</option>
    	  <option value="mc">Multiple Choice</option>
    	  <option value="writein">Write-in</option>
    	</select>
    	<br>
    	<br><br>
    	<input type="submit" value="Submit">
    </form>
</div>
<div id="questionAdded"></div>

<script>
function add() {
	var t = document.getElementById("title").value;
	var q = document.getElementById("question").value;
		q = q.split("\n").join("<br>");
	var s = document.getElementById("solution").value;
	var h = document.getElementById("hint").value;
	var l = document.getElementById("language").value;
	var d = document.getElementById("difficulty").value;
	var time = document.getElementById("time").value;
	var c = document.getElementById("category").value;

	var div = document.getElementById("questionAdded");

	var ajax = new XMLHttpRequest();
	ajax.open("GET","controller.php?action=add&title=" + t + "&question=" + q + "&solution=" + s + "&hint=" + h + 
			"&language=" + l + "&difficulty=" + d + "&time=" + time + "&category=" + c, true); 
	ajax.send();

	ajax.onreadystatechange = function(){
		if (ajax.readyState == 4 && ajax.status == 200) {
			var check = ajax.responseText; 
			div.innerHTML = check;
			
		}
		
	};

}

</script>

</body>
</html>