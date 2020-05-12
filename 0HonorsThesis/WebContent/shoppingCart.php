<?php
session_start();

if (! isset($_SESSION['user'])) {
    $_SESSION['shoppingError'] = 'You must be logged in to use this feature.';
    header("Location: view.php");
    exit();
}

?>

<html>
<head>
<meta charset="ISO-8859-1">
<script
	src="https://cdn.rawgit.com/showdownjs/showdown/1.9.1/dist/showdown.min.js"
	referrerpolicy="origin"></script>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

<title>Shopping Cart</title>
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

	<h1 class="label">Shopping Cart</h1>
	<div class="label">
		Drag and drop questions in the order that you want them to appear on
		your exam. Click the 'Save Question Order button to save your changes.
		<br> <br> When you're satisfied with the layout, create a title and
		some instructions for your exam and click the 'Convert to PDF' button
		to create your exam.
	</div>

	<div id="questions"></div>
	<form>
		<input id="title" class="shoppingCartInfo1" placeholder="Exam title:"
			required>
		<textarea id="instructions" class="shoppingCartInfo2"
			placeholder="Exam instructions:" required></textarea>

		<div id="buttonPlacement" onclick="demoFromHTML()" type="submit"></div>
	</form>
	<button id="orderButton" class="shoppingCartSaveOrder"
		onclick="updateOrder()">Save Question Order</button>
	<!-- <div id="buttonPlacement" onclick="demoFromHTML()"></div>  -->
	<div id="content"></div>


	<script>    



	var div = document.getElementById("questions");
	var hiddenQs = document.getElementById("content");
 	hiddenQs.innerHTML = "";
	var buttonPlace = document.getElementById("buttonPlacement");
	var converter = new showdown.Converter();
	

	var ajax = new XMLHttpRequest();
	ajax.open("GET","controller.php?action=getShoppingCart", true); 
	ajax.send();

	ajax.onreadystatechange = function(){
		if (ajax.readyState == 4 && ajax.status == 200) {
			var qArray = JSON.parse(ajax.responseText); 
			var button = document.createElement("button");
			var text = document.createTextNode("Convert to PDF");
			button.appendChild(text);
			button.className = "shoppingCartButton";
			buttonPlace.appendChild(button);
			var ul = document.createElement("ul");
			ul.id = "columns";			
			
			for (var i = 0; i < qArray.length; i++) {
				var li =document.createElement('li');
				li.className = "column";
				li.draggable = "true";
				li.id = qArray[i]['id'];
				var questionDiv = document.createElement("div");
				var button = document.createElement("button");
				var text = document.createTextNode("Remove from shopping cart");
				button.appendChild(text);
				button.id = qArray[i]['id'];
				button.onclick = function () {
					removeFromCart(this.id);
				}
				var md = qArray[i]['question'];
				var html = converter.makeHtml(md);
 				hiddenQs.innerHTML += qArray[i]['position'] + ". " + html + "\n\n\n\n\n";
				questionDiv.innerHTML += "Question "  + qArray[i]['position'] + ":" + html + "<br><br>";
				md = qArray[i]['solution'];
				html = converter.makeHtml(md);
				questionDiv.innerHTML += "Solution:    " + html + "<br><br>";
				md = qArray[i]['hint'];
				html = converter.makeHtml(md);
				questionDiv.innerHTML += "Hint:    " + html + "<br><br>";
				questionDiv.innerHTML += "Tags:  " + qArray[i]['language'] + ", Difficulty: " + qArray[i]['difficulty'] +
								 ", Estimated time: " + qArray[i]['time'] + " minutes, " + qArray[i]['category'] + "<br><br>";
				questionDiv.className = "shoppingCart";
				li.innerHTML = questionDiv.innerHTML;
				li.appendChild(button);				
				ul.appendChild(li);
				div.appendChild(ul);
			}
			dragAndDrop();
		}
	};


	function updateOrder() {
		var ajax = new XMLHttpRequest();
		var list = document.getElementById("questions").getElementsByTagName("UL")[0];
		var x = list.getElementsByTagName("LI").length;
		for (var i = 0; i < x; i++) {
			var qid = list.getElementsByTagName("LI")[i].id;
			var position = i + 1;
			ajax.open("GET","controller.php?action=updateCart&qid=" + qid + "&position=" + position , true); 
			ajax.send();

			ajax.onreadystatechange = function(){
				if (ajax.readyState == 4 && ajax.status == 200) {
					var message = ajax.responseText; 
				}
			};

		}
		location.reload();
	}

	function removeFromCart(qid) {
		var ajax = new XMLHttpRequest();
		ajax.open("GET","controller.php?action=removeFromCart&qid=" + qid, true); 
		ajax.send();

		ajax.onreadystatechange = function(){
			if (ajax.readyState == 4 && ajax.status == 200) {
				var message = ajax.responseText; 
				alert(message);
			}
		};
	}




function dragAndDrop() {

	var dragSrcEl = null;

	function handleDragStart(e) {
	  // Target (this) element is the source node.
	  dragSrcEl = this;

	  e.dataTransfer.effectAllowed = 'move';
	  e.dataTransfer.setData('text/html', this.outerHTML);

	  this.classList.add('dragElem');
	}
	function handleDragOver(e) {
	  if (e.preventDefault) {
	    e.preventDefault(); // Necessary. Allows us to drop.
	  }
	  this.classList.add('over');

	  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

	  return false;
	}

	function handleDragEnter(e) {
	  // this / e.target is the current hover target.
	}

	function handleDragLeave(e) {
	  this.classList.remove('over');  // this / e.target is previous target element.
	}

	function handleDrop(e) {
	  // this/e.target is current target element.

	  if (e.stopPropagation) {
	    e.stopPropagation(); // Stops some browsers from redirecting.
	  }

	  // Don't do anything if dropping the same column we're dragging.
	  if (dragSrcEl != this) {
	    // Set the source column's HTML to the HTML of the column we dropped on.
	    //alert(this.outerHTML);
	    //dragSrcEl.innerHTML = this.innerHTML;
	    //this.innerHTML = e.dataTransfer.getData('text/html');
	    this.parentNode.removeChild(dragSrcEl);
	    var dropHTML = e.dataTransfer.getData('text/html');
	    this.insertAdjacentHTML('beforebegin',dropHTML);
	    var dropElem = this.previousSibling;
	    addDnDHandlers(dropElem);
	    
	  }
	  this.classList.remove('over');
	  return false;
	}

	function handleDragEnd(e) {
	  // this/e.target is the source node.
	  this.classList.remove('over');

	  /*[].forEach.call(cols, function (col) {
	    col.classList.remove('over');
	  });*/
	}

	function addDnDHandlers(elem) {
	  elem.addEventListener('dragstart', handleDragStart, false);
	  elem.addEventListener('dragenter', handleDragEnter, false)
	  elem.addEventListener('dragover', handleDragOver, false);
	  elem.addEventListener('dragleave', handleDragLeave, false);
	  elem.addEventListener('drop', handleDrop, false);
	  elem.addEventListener('dragend', handleDragEnd, false);

	}

	var cols = document.querySelectorAll('#columns .column');
	[].forEach.call(cols, addDnDHandlers);


}




	
	function demoFromHTML() {
		var title = document.getElementById("title").value;
		var instructions = document.getElementById("instructions").value;
		
		var div = document.getElementById("content");
		div.innerHTML = div.innerHTML.split("\n").join("<br>");
	    var pdf = new jsPDF('p', 'pt', 'letter');
	    pdf.setFontSize(22);
	    pdf.text(40,50, title);
	    pdf.setFontSize(12);
	    pdf.text(40,100, instructions);
	    // source can be HTML-formatted string, or a reference
	    // to an actual DOM element from which the text will be scraped.
	    source = $('#content')[0];

	    // we support special element handlers. Register them with jQuery-style 
	    // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
	    // There is no support for any other type of selectors 
	    // (class, of compound) at this time.
	    specialElementHandlers = {
	        // element with id of "bypass" - jQuery style selector
	        '#bypassme': function (element, renderer) {
	            // true = "handled elsewhere, bypass text extraction"
	            return true
	        }
	    };
	    margins = {
	        top: 200,
	        bottom: 60,
	        left: 40,
	        width: 522
	    };
	    // all coords and widths are in jsPDF instance's declared units
	    // 'inches' in this case
	    pdf.fromHTML(
	        source, // HTML string or DOM elem ref.
	        margins.left, // x coord
	        margins.top, { // y coord
	            'width': margins.width, // max width of content on PDF
	            'elementHandlers': specialElementHandlers
	        },

	        function (dispose) {
	            // dispose: object with X, Y of the last line add to the PDF 
	            //          this allow the insertion of new lines after html
	            pdf.save('CSExam.pdf');
	        }, margins
	    );
	}

</script>

</body>
</html>