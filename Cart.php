<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="CartStyleSheet.css" />
<title>Photo Prints: Cart</title>
</head>

<body>

<nav>
<h1><a class='logo' href="Store.php">MATT TRIMBY PHOTO PRINTS</a></h1>
<ul class = 'nav'>
  <li class = 'nav'><a class = 'nav' href="Cart.php">Cart</a></li>
  <li class = 'nav'><a class = 'nav' href="Store.php">Gallery</a></li>
</ul>
</nav>

<br /><br /><br />
<h2>CART</h2>
<hr>

<?php
	session_start();
	

	if(isset($_GET["action"])){
		if($_GET["action"] == "remove"){
			$id = $_GET["id"];
			$_SESSION['cart'][$id]['quantity']--;
			if($_SESSION['cart'][$id]['quantity'] == 0){
				unset($_SESSION['cart'][$id]);
			}
		}
	}
	if(empty($_SESSION['cart'])) {
        ?>
        <div class='cartEmpty'>
          Your cart appears to be empty.
          <br /><br />
          <a href='Store.php'>Let's change that</a>
        </div>
        <?php
    }


	//Establish connection details
	$connect = mysqli_connect("csmysql.cs.cf.ac.uk", "c1525379", "GenericPass123", "c1525379");
	if (!$connect) { //test connection to mySQL
		die("Connecttion Failed: " . mysqli_connect_error());
	}
	$getPic = "SELECT * FROM Photos WHERE picNumber IN (";
    // MySQL select for only the products in the cart
    foreach($_SESSION['cart'] as $picNumber => $value) { 
                        $getPic.=$picNumber.", "; 
                    } 
                      
                    $getPic=substr($getPic, 0, -2).") ORDER BY picName ASC"; //establish mySQL action to be taken
	$result = mysqli_query($connect, $getPic); //establish variable to call connection and query
	
	$total_price = 0;

	while($row = mysqli_fetch_assoc($result)) {  // while loop that goes through table row by row and performs and action
		$total_price += $_SESSION['cart'][$row["picNumber"]]["price"] * $_SESSION['cart'][$row["picNumber"]]["quantity"];
		?>
	<!--For CSS formatting purposes each attribute of the row is given its own div-->
	<div class = "product">

	<div class = "pic"><img class = 'picPreview' src="<?php echo $row["picRef"]//gets image source from mySQL server?>"/></div>

	<div class = "picName"><?php echo $row["picName"] ?></div>

	<div class = "picPrice">£<?php echo $row["picPrice"]?></div>

	<div class = "qty">Qty: <?php echo $_SESSION['cart'][$row["picNumber"]]["quantity"]?></div>

	<div class = "remove"><a class='remove' href="Cart.php?action=remove&id=<?php echo $row["picNumber"] ?>">remove</a></div>

	<div class = "picDesc"><?php echo $row["picDesc"]?></div>

	
	<br />

	</div>

	<br />

<?php } // closes brackets of the while loop
	
	if(!empty($_SESSION['cart'])){
?>

	<div class="total">Total price: £<?php echo "$total_price"?></div>
	<br />
	<div class="pay"><form class='pay' action="Payment.php"><input type='submit' class='button' value='Pay Now!'/></form></div>
	<br /><br />
	<?php
	$_SESSION["total_price"] = $total_price;
	}


	?>


<footer class="fixed">
  <p id = footertextfixed> Matt Trimby Photgraphy </p> 
</footer>

</body>

</html>
