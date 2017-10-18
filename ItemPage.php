<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="CartStyleSheet.css" />
<title>Matt Trimby Photo Prints</title>
</head>

<body>

<nav>
<h1><a class='logo' href="Store.php">MATT TRIMBY PHOTO PRINTS</a></h1>
<ul class = 'nav'>
  <li class = 'nav'><a class = 'nav' href="Cart.php">Cart</a></li>
  <li class = 'nav'><a class = 'nav' href="Store.php">Gallery</a></li>
</ul>
</nav>

<br /><br /><br /><br />

<?php 
	session_start();

	if(isset($_GET["id"])){
		$id = $_GET["id"];
	}

	if (isset($_GET["action"])) {
		if($_GET["action"] == "add"){
          
	        if(isset($_SESSION['cart'][$id])){ 
	              
	            $_SESSION['cart'][$id]['quantity']++; 
	            
	        }
	        else{ 
	            $query1="SELECT * FROM Photos WHERE picNumber={$id}"; 
	            $result1 = mysqli_query($connect, $query1);

	            while($row1=mysqli_fetch_assoc($result1)){
	                  
	            	$_SESSION['cart'][$row1['picNumber']]=array( "quantity" => 1, "price" => $row1['picPrice']);
	            }
	        }
	                  
		}
		else if($_GET['action'] == 'end'){
			session_unset();
		}
	}



	//Establish connection details
	$connect = mysqli_connect("csmysql.cs.cf.ac.uk", "c1525379", "GenericPass123", "c1525379");
	if (!$connect) { //test connection to mySQL
		die("Connecttion Failed: " . mysqli_connect_error());
	}
	
	$getPic = "SELECT * FROM Photos WHERE picNumber={$id}"; //establish mySQL action to be taken
	$result = mysqli_query($connect, $getPic); //establish variable to call connection and query
	

	while($row = mysqli_fetch_assoc($result)){  // while loop that goes through table row by row and performs and action
		?>
	<!--For CSS formatting purposes each attribute of the row is given its own div-->
	<div class = "product">

	<div class = "pic"><img class = 'picPreview' src="<?php echo $row["picRef"]//gets image source from mySQL server?>"/></div>

	<div class = "picName"><?php echo $row["picName"] ?></div>

	<div class = "picPrice">£<?php echo $row["picPrice"]?></div>

	<div class='add'><a href="ItemPage.php?action=add&id=<?php echo $row["picNumber"] ?>">+ Add to basket</a></div>

	<div class = "longDesc"><?php echo $row["longDesc"]?></div>

	
	<br />

	</div>
<?php } ?>


<footer class='fixed'>
  <p id = footertextfixed> Matt Trimby Photgraphy </p> 
</footer>

</body>

</html>