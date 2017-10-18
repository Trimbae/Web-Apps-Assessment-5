<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="StyleSheet.css" />
<title>Matt Trimby Photo Prints</title>
<script type="text/javascript">

	function newMessage(message, node){ //when called, creates new error message
		thisMessage = document.createTextNode(message);
		divNode = document.getElementById(node);
		divNode.appendChild(thisMessage);
	}
	function clearMessage(node){ //when called, clears a given message
		parentNode = document.getElementById(node);
		childNode = parentNode.childNodes[0];
		parentNode.removeChild(childNode);
	}
	function helpMessage(message){ //when called, clears last help message before creating a new one
		clearMessage('help');
		newMessage(message, 'help');
	}

	function noData(x){

		// Uses regex to strip whitespace and check for input data.
		if (x.replace(/\s/g, "").length > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	function validatePayment(form){ 
		var cardNo = form.cardNo.value; //gets variables from form
		var expMonth = form.expMonth.value;
		var expYear = form.expYear.value;
		var name = form.name.value;
		var secNo = form.secNo.value;

		var errorNo = 0;
 
 		//input validation
		if(isNaN(cardNo) || cardNo.length != 16 || noData(cardNo) ){ //checks if input is invalid
			errorNo += 1;
			if(!document.getElementById("invalidNo").hasChildNodes()){ //if invalid input, checks if there is an error message
				newMessage("Card number must be 16 digits", "invalidNo"); //if no error message already present, create new error message
			}
		}
		else{
			if(document.getElementById("invalidNo").hasChildNodes()){ //if input is now valid, remove error message
				clearMessage("invalidNo");
			}
		}


		if(name == null || noData(name)){
			errorNo += 1;
			if(!document.getElementById("invalidName").hasChildNodes()){
				newMessage("Please enter a name", "invalidName");
			}
		}
		else{
			if(document.getElementById("invalidName").hasChildNodes()){
				clearMessage("invalidName");
			}
		}

		if((expMonth < 1 || expMonth > 12) || isNaN(expMonth) || expMonth != parseInt(expMonth) || noData(expMonth)){
			errorNo += 1;
			if(!document.getElementById("invalidMonth").hasChildNodes()){
				newMessage("Invalid month - must be between 1 and 12", "invalidMonth");

			}
		}
		else{
			if(document.getElementById("invalidMonth").hasChildNodes()){
				clearMessage("invalidMonth");
			}
		}


		if((expYear < 2017 || isNaN(expYear)) || expYear.length != 4 || noData(expYear) || expYear != parseInt(expYear)){
			errorNo += 1;
			if(!document.getElementById("invalidYear").hasChildNodes()){
				newMessage("Invalid Year - Year must be 2017 onwards", "invalidYear");

			}
		}
		else{
			if(document.getElementById("invalidYear").hasChildNodes()){
				clearMessage("invalidYear");

			}
		}
		if(isNaN(secNo) || secNo.length != 3 || secNo != parseInt(secNo) || noData(secNo)){
			errorNo += 1;
			if(!document.getElementById("invalidSecNo").hasChildNodes()){
				newMessage("Security code must be a 3 digit number", "invalidSecNo");
				
			}
		}
		else{
			if(document.getElementById("invalidSecNo").hasChildNodes()){
				clearMessage("invalidSecNo");
			}
		}
		if(errorNo == 0){ //if there are no validation errors, the form is submitted and the user recieves an alert
			alert("Payment Submitted");
			return true;
		}
		else{
			return false;
		}

	}
</script>
</head>

<body>

<nav>
<h1><a class='logo' href="Store.php">MATT TRIMBY PHOTO PRINTS</a></h1>
<ul class = 'nav'>
  <li class = 'nav'><a class = 'nav' href="Cart.php">Cart</a></li>
  <li class = 'nav'><a class = 'nav' href="Store.php">Gallery</a></li>
</ul>
</nav>

<div>
<br /><br /><br />
</div>

<h2>PAYMENT</h2>
<hr class='payment'>

<?php 
	session_start();

	if(isset($_SESSION["total_price"])){
		$total_price = $_SESSION["total_price"];
	}
?>

<div id="payment"> 
	<form action="#" onsubmit="return validatePayment(this)"> <!-- Form which validates user input before submission -->
		Card Number: <input type='text' id="cardNo" size="16" placeholder="0123456789123456" onFocus="helpMessage('16 digit number on front of card')" /><br />

		<p class="invalid" id='invalidNo'></p><br /> <!-- sets up p element for script to insert into -->

		Expiry Date: <input type='text' id="expMonth" size="3" placeholder="MM" onFocus="helpMessage('Month of expiry date - must be between 1 and 12', 'help')"  />

		<input type='text' id="expYear" size="5" placeholder="YYYY" onFocus="helpMessage('Year of expiry date - must be 2017 or later')"/><br />

		<p class='invalid' id="invalidMonth"></p><p class='invalid' id='invalidYear'></p><br />

		Name on card: <input type='text' id="name" size="30" placeholder="Mr John Smith" onFocus="helpMessage('Full name on the front of the card')"/><br />

		<p class='invalid' id='invalidName'></p><br />

		Security Code: <input type='text' id="secNo" size="3" placeholder="123" onFocus="helpMessage('3 digit CVV security code on back of card')" /><br />

		<p class='invalid' id='invalidSecNo'></p><br />

		<p class="total">Total price: £<?php echo "$total_price"?></p>

		<input class='pay' type='submit' value="Pay Now"/><br /><br />

		<!-- sets up element for help message to be inserted into-->
		<p class='help' id='help'> 
	</form>
</div>



<footer class='fixed'>
  <p id = footertextfixed> Matt Trimby Photgraphy </p> 
</footer>

</body>

</html>
