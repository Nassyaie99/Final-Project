<?php
include_once ("dbconnect.php");
session_start();
$useremail = "Guest";
if (isset($_SESSION['sessionid']))
{
    $useremail = $_SESSION['user_email'];
    $user_name = $_SESSION['user_name'];
}
$carttotal = 0;
if (isset($_GET['submit']))
{
    include_once ("dbconnect.php");
    if ($_GET['submit'] == "cart")
    {
        if ($useremail != "Guest")
        {
            $id = $_GET['id'];
            $cartqty = "1";
            $stmt = $conn->prepare("SELECT * FROM tbl_carts WHERE user_email = '$useremail' AND item_id = '$id'");
            $stmt->execute();
            $number_of_rows = $stmt->rowCount();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();
            if ($number_of_rows > 0)
            {
                foreach ($rows as $carts)
                {
                    $cartqty = $carts['cart_qty'];
                }
                $cartqty = $cartqty + 1;
                $updatecart = "UPDATE `tbl_carts` SET `cart_qty`= '$cartqty' WHERE user_email = '$useremail' AND item_id = '$id'";
                $conn->exec($updatecart);
                echo "<script>alert('Cart updated')</script>";
                echo "<script> window.location.replace('index.php')</script>";
            }
            else
            {
                $addcart = "INSERT INTO `tbl_carts`(`user_email`, `item_id`, `cart_qty`) VALUES ('$useremail','$id','$cartqty')";
                try
                {
                    $conn->exec($addcart);
                    echo "<script>alert('Success')</script>";
                    echo "<script> window.location.replace('index.php')</script>";
                }
                catch(PDOException $e)
                {
                    echo "<script>alert('Failed')</script>";
                }
            }

        }
        else
        {
            echo "<script>alert('Please login or register')</script>";
            echo "<script> window.location.replace('login.php')</script>";
        }
    }
    if ($_GET['submit'] == "search")
    {
        $search = $_GET['search'];
        $sqlquery = "SELECT * FROM tbl_product WHERE title LIKE '%$search%'";
    }
}


$stmtqty = $conn->prepare("SELECT * FROM tbl_carts WHERE user_email = '$useremail'");
$stmtqty->execute();
$resultqty = $stmtqty->setFetchMode(PDO::FETCH_ASSOC);
$rowsqty = $stmtqty->fetchAll();
foreach ($rowsqty as $carts)
{
    $carttotal = $carts['cart_qty'] + $carttotal;
}


?>
<!DOCTYPE html>
<html>
<title>Muaz Photography</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../js/script.js"></script>

<body>
<div class="w3-panel">
<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Muaz Photography</span>
  <p></p>
</div>
<div class="w3-container">
    <div class="w3-display-container mySlides">
      <img src="img/DSC03215.JPG" style="width:100%">
      <div class="w3-display-topleft w3-container w3-padding-32">
        <span class="w3-white w3-padding-large w3-animate-bottom">Choose Your Desire</span>
      </div>
    </div>

<div class="w3-header w3-container w3-black w3-padding-32 w3-center">
        <h1 style="font-size:calc(8px + 4vw);">Product Available</h1>
        <p style="font-size:calc(8px + 1vw);;">We Can Serve You Better</p>
    </div>

<body>
    <!-- Sidebar (hidden by default) -->
    <nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:20%;min-width:200px" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button">Close Menu</a>
        <a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button">Login</a>
        <a href="register.php" onclick="w3_close()" class="w3-bar-item w3-button">Register</a>
        <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button">Product (Current Page)</a>
        <a href="mycart.php" onclick="w3_close()" class="w3-bar-item w3-button">Carts</a>
        <a href="mypayment.php" onclick="w3_close()" class="w3-bar-item w3-button">Payment</a>
        <a href="landingpage.html" onclick="w3_close()" class="w3-bar-item w3-button">About</a>
        <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button">Logout</a>
    </nav>

    <!-- Top menu -->
    <div class="w3-top">
        <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
            <div class="w3-button w3-padding-16 w3-opacity w3-left" onclick="w3_open()">☰</div>
            <a href="mycart.php"> <div class="w3-right w3-animate-opacity w3-padding-16" id = "carttotalidb" >Cart (<?php echo $carttotal?>)</div></a>
            
        </div>
    </div>
    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
    <div class="w3-container w3-center"><p>Welcome <?php echo $user_name?> </p></div>
    <div class="w3-container w3-card w3-padding w3-row w3-round" style="width:100%">
        <form class="w3-container" action="index.php" method="get">
            <div class="w3-twothird"><input class="w3-input w3-border w3-round w3-center" placeholder = "Enter your search term here" type="text" name="search"></div>
            <div class="w3-third"><input class="w3-input w3-border w3-blue w3-round" type="submit" name="submit" value="search"></div>
        </form>
    </div>
    <hr>
        
        <div class="w3-grid-template">
             <?php
             $cart = "cart";
             foreach ($rows as $product) {
                $id = $product['id'];
                $title = $product['title'];
                $description = $product['description'];
                $price = $product['price'];
                    
                    echo "<div class='w3-center w3-padding-small'><div class = 'w3-card w3-round-large'>
                    <div class='w3-padding-small'><a href='item_details.php?item_id=$id'><img class='w3-container w3-image' 
                    src=res/images/$id.png onerror=this.onerror=null;this.src='res/images/profile.png'></a></div>
                    <b>$title</b><br>RM $price <br>
                    <input type='button' class='w3-button w3-blue w3-round' id='button_id' value='Add to Cart' onClick='addCart($id);'><br><br>
                    </div></div>
                    <a href= 'index.php?id=$id&submit=$cart' class='w3-btn w3-blue w3-round'>Add to Cart</a><br><br>";
                }
             ?>
        </div>
    </div>
    <?php
    
    ?>
    <footer class="w3-row-padding w3-padding-32">
        <hr></hr>
         <p class="w3-center">MUAZ PHOTOGRAPHY&reg;</p>
    
    </footer>
   
 <script>
 function addCart(id) {
	jQuery.ajax({
		type: "GET",
		url: "updatecartajax.php",
		data: {
			id: id,
			submit: 'add',
		},
		cache: false,
		dataType: "json",
		success: function(response) {
		    var res = JSON.parse(JSON.stringify(response));
		    console.log("HELLO ");
			console.log(res.status);
			if (res.status == "success") {
			    console.log(res.data.carttotal);
				//document.getElementById("carttotalida").innerHTML = "Cart (" + res.data.carttotal + ")";
				document.getElementById("carttotalidb").innerHTML = "Cart (" + res.data.carttotal + ")";
				alert("Success");
			}
			if (res.status == "failed") {
			    alert("Please login/register account");
			}
			

		}
	});
}
</script>
</body>

</html>
