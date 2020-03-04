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
	  <option value="any" selected = "selected">Any</option>
	  <option value="python">Python</option>
	  <option value="c">C</option>
	  <option value="java">Java</option>
	  <option value="html">HTML</option>
	</select>
	<br>
	<br>
	Estimated time length: 
	<select id="time">
	  <option value="any" selected = "selected">Any</option>
	  <option value="10">10</option>
	  <option value="20">20</option>
	  <option value="30">30</option>
	  <option value="50">50</option>
	</select>
	<br>
	<br>
	Estimated difficulty: 
	<select id="difficulty">
	  <option value="any" selected = "selected">Any</option>
	  <option value="1">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	  <option value="4">4</option>
	  <option value="5">5</option>
	</select>
	<br>
	<br>
	Category: 
	<select id="category">
	  <option value="any" selected = "selected">Any</option>
	  <option value="fib">Fill in the blank</option>
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

<div id="questionInfo" class="questionInfo">
</div>


<script>
function search() {
	var l = document.getElementById("language").value;
	var t = document.getElementById("time").value;
	var d = document.getElementById("difficulty").value;
	var c = document.getElementById("category").value;

	var div = document.getElementById("questions");

	var ajax = new XMLHttpRequest();
	ajax.open("GET","controller.php?action=search&language=" + l + "&time=" + t + "&difficulty=" + d + "&category=" + c, true); 
	ajax.send();

	ajax.onreadystatechange = function(){
		if (ajax.readyState == 4 && ajax.status == 200) {
			var qArray = JSON.parse(ajax.responseText); 
			var questionDiv = document.createElement("div");
			for (var i = 0; i < qArray.length; i++) {
				var questionDiv = document.createElement("div");
				questionDiv.innerHTML += (i + 1) + "<br>";
				questionDiv.innerHTML += qArray[i]['question']+"<br><br>";
				questionDiv.id = qArray[i]['id'];
				questionDiv.onclick = function () {
// 									alert(this.id);
									viewQuestion(this.id);
									
									}
				questionDiv.className = "questionDiv";
				div.appendChild(questionDiv);
			}
		}
	};
}

function viewQuestion(id) {
	var div = document.getElementById("questionInfo");
// 	div.visibility = 'visible';
	div.innerHTML = "";
	
	var ajax = new XMLHttpRequest();
	ajax.open("GET","controller.php?action=getInfo&id=" + id, true); 
	ajax.send();

	ajax.onreadystatechange = function(){
		if (ajax.readyState == 4 && ajax.status == 200) {
			var qArray = JSON.parse(ajax.responseText); 
			for (var i = 0; i < qArray.length; i++) {
				var button = document.createElement("button");
				var text = document.createTextNode("Add to shopping cart");
				button.appendChild(text);
				div.innerHTML += "Question:    " + qArray[i]['question'] + "<br><br>";
				div.innerHTML += "Solution:    " + qArray[i]['solution'] + "<br><br>";
				div.innerHTML += "Hint:    " + qArray[i]['hint'] + "<br><br>";
				div.innerHTML += "Tags:  " + qArray[i]['language'] + ", Difficulty: " + qArray[i]['difficulty'] +
								 ", Estimated time: " + qArray[i]['time'] + " minutes, " + qArray[i]['category'] + "<br><br>";
				div.appendChild(button);
			}
		}
	};
	
}

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