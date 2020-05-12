<?php
session_start();

?>


<html>
<head>
<meta charset="ISO-8859-1">
<script
	src="https://cdn.rawgit.com/showdownjs/showdown/1.9.1/dist/showdown.min.js"
	referrerpolicy="origin"></script>

<title>Search</title>
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

	<h3 class="label">Search the Questions Database</h3>
	<div class="label">Search using a keyword or by various tags.</div>
	<div id="searchQueries" class="searchQueries">
		<form onsubmit="search();return false">
			Keyword: <input id="keyword"> <br> <br> Language: <select
				id="language">
				<option value="any" selected="selected">Any</option>
				<option value="python">Python</option>
				<option value="c">C</option>
				<option value="java">Java</option>
				<option value="html">HTML</option>
			</select> <br> <br> Estimated time length: <select id="time">
				<option value="any" selected="selected">Any</option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="50">50</option>
			</select> <br> <br> Estimated difficulty: <select id="difficulty">
				<option value="any" selected="selected">Any</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select> <br> <br> Category: <select id="category">
				<option value="any" selected="selected">Any</option>
				<option value="fib">Fill in the blank</option>
				<option value="mc">Multiple Choice</option>
				<option value="writein">Write-in</option>
			</select> <br> <br> <br> <input type="submit" value="Search">
		</form>
	</div>

	<div id="questions" class="questions"></div>

	<div id="questionInfo" class="questionInfo"></div>



	<script>
function search() {
	var l = document.getElementById("language").value;
	var t = document.getElementById("time").value;
	var d = document.getElementById("difficulty").value;
	var c = document.getElementById("category").value;
	var k = document.getElementById("keyword").value;

	var div = document.getElementById("questions");
	var converter = new showdown.Converter();

	var ajax = new XMLHttpRequest();
	ajax.open("GET","controller.php?action=search&language=" + l + "&time=" + t + "&difficulty=" + d + "&category=" + c + "&keyword=" + k, true); 
	ajax.send();

	ajax.onreadystatechange = function(){
		if (ajax.readyState == 4 && ajax.status == 200) {
			var qArray = JSON.parse(ajax.responseText); 
			var questionDiv = document.createElement("div");
			for (var i = 0; i < qArray.length; i++) {
				var questionDiv = document.createElement("div");
				questionDiv.innerHTML += (i + 1) + "<br>";
				var md = qArray[i]['question'];
				var html = converter.makeHtml(md);
				questionDiv.innerHTML += html + "<br><br>";
				questionDiv.id = qArray[i]['id'];
				questionDiv.onclick = function () {
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
 	div.style.visibility = 'visible';
	div.innerHTML = "";
	var converter = new showdown.Converter();
	
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
				button.onclick = function () {
					addToCart(qArray[0]['id']);
				}
				var button2 = document.createElement("button");
				var text = document.createTextNode("Delete question from database");
				button2.appendChild(text);
				button2.onclick = function () {
					deleteQuestion(qArray[0]['id']);
				}
				var md = qArray[i]['question'];
				var html = converter.makeHtml(md);
				div.innerHTML += "Question:    " + html + "<br><br>";
				md = qArray[i]['solution'];
				html = converter.makeHtml(md);
				div.innerHTML += "Solution:    " + html + "<br><br>";
				md = qArray[i]['hint'];
				html = converter.makeHtml(md);
				div.innerHTML += "Hint:    " + html + "<br><br>";
				div.innerHTML += "Tags:  " + qArray[i]['language'] + ", Difficulty: " + qArray[i]['difficulty'] +
								 ", Estimated time: " + qArray[i]['time'] + " minutes, " + qArray[i]['category'] + "<br><br>";
				div.appendChild(button);
				div.innerHTML += "&nbsp&nbsp";
				div.appendChild(button2);
			}
		}
	};
	
}

function addToCart(qid) {
	var ajax = new XMLHttpRequest();
	ajax.open("GET","controller.php?action=addToCart&qid=" + qid, true); 
	ajax.send();

	ajax.onreadystatechange = function(){
		if (ajax.readyState == 4 && ajax.status == 200) {
			var message = ajax.responseText; 
			alert(message);
		}
	};
}

function deleteQuestion(qid) {
	var ajax = new XMLHttpRequest();
	ajax.open("GET","controller.php?action=deleteQuestion&qid=" + qid, true); 
	ajax.send();

	ajax.onreadystatechange = function(){
		if (ajax.readyState == 4 && ajax.status == 200) {
			var message = ajax.responseText; 
			alert(message);
		}
	};
}
</script>
</body>
</html>