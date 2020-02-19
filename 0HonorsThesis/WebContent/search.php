<?php

session_start();

?>


<html>
<head>
<meta charset="ISO-8859-1">
<title>Search</title>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>

<div id="searchQueries" class="searchQueries">
<form onsubmit="search();return false">
	Language: 
	<select id="language">
	  <option value="python" selected = "selected">Python</option>
	  <option value="c">C</option>
	  <option value="java">Java</option>
	  <option value="html">HTML</option>
	</select>
	<br>
	<br>
	Estimated time length: 
	<select id="time">
	  <option value="10" selected = "selected">10</option>
	  <option value="20">20</option>
	  <option value="30">30</option>
	  <option value="50">50</option>
	</select>
	<br>
	<br>
	Estimated difficulty: 
	<select id="difficulty">
	  <option value="1" selected = "selected">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	  <option value="4">4</option>
	  <option value="5">5</option>
	</select>
	<br>
	<br>
	Category: 
	<select id="category">
	  <option value="fib" selected = "selected">Fill in the blank</option>
	  <option value="mc">Multiple Choice</option>
	  <option value="writein">Write-in</option>
	</select>
	<br>
	<br>
	<br>
	<input type="submit" value="Search">
</form>
</div>

<div id="questions" class="questions">
</div>

<div id="view" class="view">
</div>


<script>
function search() {
	var l = document.getElementById("language").value;
	var t = document.getElementById("time").value;
	var d = document.getElementById("difficulty").value;
	var c = document.getElementById("category").value;

	var div = document.getElementById("questions");

	var ajax = new XMLHttpRequest();
	ajax.open("GET","controller.php?language=" + l + "&time=" + t + "&difficulty=" + d + "&category=" + c, true); 
	ajax.send();

	ajax.onreadystatechange = function(){
		if (ajax.readyState == 4 && ajax.status == 200) {
			console.log(ajax);
			var qArray = JSON.parse(ajax.responseText); 
			div.innerHTML += "<ul>";
			for (var i = 0; i < qArray.length; i++) {
				div.innerHTML += "<li>"+qArray[i]['question']+"</li>"
			}
			div.innerHTML += "</ul>";			
		}
	};
}

// function viewQuestion(n) {
// 	var questions = document.getElementById("questions");
// 	questions.style.visibility = "hidden";
// 	questions.style.display = "none";
// 	var view = document.getElementById("view");
// 	var div = document.getElementById(n);
// 	view.innerHTML = '';
// 	view.innerHTML += '<button type="button" class="buttons" onclick="backButtonClick()">Back</button>';
// 	view.innerHTML += '<button type="button" class="buttons" onclick="addToCart()">Add to Cart</button><br><br>';
// 	if (n == 1) {
// 		view.innerHTML += 'Tags: <a>python</a> , <a>5min</a><br><br>';
// 	}
// 	else if (n == 2) {
// 		view.innerHTML += 'Tags: <a>math</a> , <a>10min</a><br><br>';
// 	}
// 	else if (n == 3) {
// 		view.innerHTML += 'Tags: <a>html</a> , <a>a whole semester</a><br><br>';
// 	}
// 	else if (n == 4) {
// 		view.innerHTML += 'Tags: <a>python</a> , <a>10min</a><br><br>';
// 	}
// 	view.innerHTML += div.innerHTML;
// 	view.innerHTML += "<br><br>Answer: what?";
// 	view.style.visibility = "visible";
// 	view.style.display = "inline-block";
	
// }

// function backButtonClick() {
// 	var div = document.getElementById("questions");
// 	div.style.visibility = "visible";
// 	div.style.display = "inline-block";
// 	var view = document.getElementById("view");
// 	view.style.visibility = "hidden";
// 	view.style.display = "none";
// }

// var string = "";
// localStorage.setItem("questions", array);
// function addToCart() {
// 	string += "1 ";
// 	string += "2 ";
// 	string += "3 ";
// 	string += "4";
// 	localStorage.setItem("questions", string);
// }
</script>
</body>
</html>