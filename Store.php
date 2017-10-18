<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="StyleSheet.css" />
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

<div>
<img class = 'head' src="Header.png" alt="Matt Trimby" />
</div>

<h2>BUY PRINTS</h2>
<hr>
<form method='get' action='Store.php' class='filter'>
	<select name='filter'>
		<option name='Price Low-High' value="PL2H">Price Low-High</option>
		<option name='Price High-Low' value='PH2L'>Price High-Low</option>
		<option name='Name A-Z' value="NA2Z">Name A-Z</option>
		<option name="Name Z-A" value="NZ2A">Name Z-A</option>
	</select>
	<input type='submit' value='sort'/>
</form>

<?php 
	
	session_start();

	$connect = mysqli_connect("csmysql.cs.cf.ac.uk", "c1525379", "GenericPass123", "c1525379");
	if (!$connect) { //test connection to mySQL
		die("Connecttion Failed: " . mysqli_connect_error());
	}

	if(isset($_GET['filter'])){
		$order = $_GET['filter'];
		if($order == 'PL2H'){
			$query = "SELECT * FROM Photos ORDER BY picPrice ASC";
		}
		if($order == 'PH2L'){
			$query = "SELECT * FROM Photos ORDER BY picPrice DESC";
		}
		if($order == 'NA2Z'){
			$query = "SELECT * FROM Photos ORDER BY picName ASC";
		}
		if($order == 'NZ2A'){
			$query = "SELECT * FROM Photos ORDER BY picName DESC";
		}
	}else{
		$query = "SELECT * FROM Photos ORDER BY picPrice asc";
	}

	if (isset($_GET["action"])) {
		if($_GET["action"] == "add"){
          
	        $id= $_GET["id"];

	          
	        if(isset($_SESSION['cart'][$id])){ 
	              
	            $_SESSION['cart'][$id]['quantity']++; 
	            
	        }
	        else{ 

	        	$query2="SELECT * FROM Photos WHERE picNumber={$id}"; 
	        	$result2 = mysqli_query($connect, $query2);

	            while($row2=mysqli_fetch_assoc($result2)){
	                  
	            	$_SESSION['cart'][$row2['picNumber']]=array( "quantity" => 1, "price" => $row2['picPrice']);
	            }
	        }
	         $query1="SELECT * FROM Photos WHERE picNumber={$id}"; 
	        $result1 = mysqli_query($connect, $query1);


	        while($row1=mysqli_fetch_assoc($result1)){
	        	$addedMessage = $row1['picName']." added to cart!";
				echo "<script type='text/javascript'>alert('$addedMessage');</script>";
			}
	                  
		}
		else if($_GET['action'] == 'end'){
			session_unset();
		}
	}
	//Establish connection details
	

	$result = mysqli_query($connect, $query); //establish variable to call connection and query
	
	while($row = mysqli_fetch_assoc($result)) {  // while loop that goes through table row by row and performs and action?>
	<!--For CSS formatting purposes each attribute of the row is given its own div-->
	<div class = "product">

	<div class = "pic"><a href="ItemPage.php?id=<?php echo $row["picNumber"]?>"><img class = 'picPreview' src="<?php echo $row["picRef"]?>"/></a></div>

	<div class = "picName"><a href="ItemPage.php?id=<?php echo $row["picNumber"]?>"><?php echo $row["picName"] ?></a></div>

	<div class = "picPrice">£<?php echo $row["picPrice"]?></div>

	<div class='add'><a href="Store.php?action=add&id=<?php echo $row["picNumber"] ?>">+ Add to basket</a></div>

	<br />

	<div class = "picDesc"><?php echo $row["picDesc"]?></div>

	

	<br />

	</div>

	<br />

<?php } // closes brackets of the while loop?>


<footer>
  <p id = footertext> Matt Trimby Photgraphy </p> 
</footer>

</body>

</html>
