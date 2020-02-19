<?php

session_start();

?>

<html>
<head>
<meta charset="ISO-8859-1">
<title>Add a Question</title>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>
<h3>Your Question:</h3>
<form onsubmit="add()">
	Title: 
	<br><input id="title" class="input" type="text">
	<br>
	Question: 
	<br><input id="question" class="input" type="text">
	<br>
	Solution: 
	<br><input id="solution" class="input" type="text">
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

<div id="questionAdded"></div>

<script>
function add() {
	var t = document.getElementById("title").value;
	var q = document.getElementById("question").value;
	var s = document.getElementById("solution").value;
	var h = document.getElementById("hint").value;
	var l = document.getElementById("language").value;
	var d = document.getElementById("difficulty").value;
	var time = document.getElementById("time").value;
	var c = document.getElementById("category").value;

	var div = document.getElementById("questionAdded");

	var ajax = new XMLHttpRequest();
	ajax.open("GET","controller.php?title=" + t + "&question=" + q + "&solution=" + s + "&hint=" + h + 
			"&language=" + l + "&difficulty=" + d + "&time=" + time + "&category=" + c, true); 
	ajax.send();

	ajax.onreadystatechange = function(){
		if (ajax.readyState == 4 && ajax.status == 200) {
			var check = ajax.responseText; 
			div.innerHTML = check;
			
		}
		
	};

// 	t = '';
// 	q = '';
// 	a = '';
// 	h = '';	
}




</script>

</body>
</html>