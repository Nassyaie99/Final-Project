<?php
include_once("dbconnect.php");
session_start();
$useremail = "Guest";
if (isset($_SESSION['sessionid'])) {
    $useremail = $_SESSION['user_email'];
}else{
   echo "<script>alert('Please login or register')</script>";
   echo "<script> window.location.replace('login.php')</script>";
}
if (isset($_GET['submit'])) {
    if ($_GET['submit'] == "add"){
        $itemid = $_GET['itemid'];
        $qty = $_GET['qty'];
        $cartqty = $qty + 1 ;
        $updatecart = "UPDATE `tbl_carts` SET `cart_qty`= '$cartqty' WHERE user_email = '$useremail' AND item_id = '$itemid'";
        $conn->exec($updatecart);
        echo "<script>alert('Cart updated')</script>";
    }
    if ($_GET['submit'] == "remove"){
        $itemid = $_GET['itemid'];
        $qty = $_GET['qty'];
        if ($qty == 1){
            $updatecart = "DELETE FROM `tbl_carts` WHERE user_email = '$useremail' AND item_id = '$itemid'";
            $conn->exec($updatecart);
            echo "<script>alert('Item removed')</script>";
        }else{
            $cartqty = $qty - 1 ;
            $updatecart = "UPDATE `tbl_carts` SET `cart_qty`= '$cartqty' WHERE user_email = '$useremail' AND item_id = '$itemid'";
            $conn->exec($updatecart);    
            echo "<script>alert('Removed')</script>";
        }
        
    }
}


$stmtqty = $conn->prepare("SELECT * FROM tbl_carts INNER JOIN tbl_product ON tbl_carts.item_id = tbl_product.item_id WHERE tbl_carts.user_email = '$useremail'");
$stmtqty->execute();
$resultqty = $stmtqty->setFetchMode(PDO::FETCH_ASSOC);
$rowsqty = $stmtqty->fetchAll();
foreach ($rowsqty as $carts) {
   $carttotal = $carts['cart_qty'] + $carttotal;
}

function subString($str)
{
    if (strlen($str) > 15)
    {
        return $substr = substr($str, 0, 15) . '...';
    }
    else
    {
        return $str;
    }
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
<script src="../js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<body>
    <!-- Sidebar (hidden by default) -->
    <nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:20%;min-width:200px" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button">Close Menu</a>
        <a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button">Login</a>
        <a href="register.php" onclick="w3_close()" class="w3-bar-item w3-button">Register</a>
        <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button">Product</a>
        <a href="mycart.php" onclick="w3_close()" class="w3-bar-item w3-button" id = "carttotalida">My Carts (<?php echo $carttotal?>)</a>
        <a href="mypayment.php" onclick="w3_close()" class="w3-bar-item w3-button">Payment History</a>
        <a href="landingpage.php" onclick="w3_close()" class="w3-bar-item w3-button">About</a>
        <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button">Logout</a>
    </nav>

    <!-- Top menu -->
    <div class="w3-top">
        <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
            <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
            <div class="w3-right w3-padding-16" id = "carttotalidb" >Cart (<?php echo $carttotal?>)</div>
            <div class="w3-center w3-padding-16">AfiraHerbs</div>
        </div>
    </div>
    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
        <div class="w3-container w3-center"><p>Cart for <?php echo $useremail?> </p></div><hr>
        <div class="w3-grid-template">
             <?php
             
             $total_payable = 0.00;
             foreach ($rows as $product) {
                    $id = $product['id'];
                    $title = $product['title'];
                    $description = $product['description'];
                    $price = $product['price'];
                    $item_total = $item_qty * $item_price;
                    $total_payable = $item_total + $total_payable;
                    echo "<div class='w3-center w3-padding-small' id='itemcard_$id'><div class = 'w3-card w3-round-large'>
                    <div class='w3-padding-small'><a href='item_details.php?itemid=$id'><img class='w3-container w3-image' 
                    src=../images/items/$id.jpg onerror=this.onerror=null;this.src='../images/items/default.jpg'></a></div>
                    <b>$title</b><br>RM $price/unit<br>
                    <input type='button' class='w3-button w3-red' id='button_id' value='-' onClick='removeCart($itemid,$item_price);'>
                    <label id='qtyid_$id'>
                    <input type='button' class='w3-button w3-green' id='button_id' value='+' onClick='addCart($itemid,$item_price);'>
                    <br>
                    <b><label id='itemprid_$id'> Price: RM $item_total</label></b><br></div></div>";
                }
             ?>
        </div>
        <?php 
        echo "<div class='w3-container w3-padding w3-block w3-center'><p><b><label id='totalpaymentid'> Total Amount Payable: RM $total_payable</label>
        </b></p><a href='payment.php?email=$useremail&amount=$total_payable' class='w3-button w3-round w3-blue'> Pay Now </a> </div>";
        ?>
        
    <footer class="w3-row-padding w3-padding-32">
        <hr></hr>
         <p class="w3-center">Muaz Photogarphy&reg;</p>
    
    </footer>
  <script>
 function addCart(itemid, item_price) {
	jQuery.ajax({
		type: "GET",
		url: "mycartajax.php",
		data: {
			itemid: itemid,
			submit: 'add',
			itemprice: item_price
		},
		cache: false,
		dataType: "json",
		success: function(response) {
			var res = JSON.parse(JSON.stringify(response));
			console.log(res.data.carttotal);
			if (res.status = "success") {
				var itemid = res.data.itemid;
				document.getElementById("carttotalida").innerHTML = "Cart (" + res.data.carttotal + ")";
				document.getElementById("carttotalidb").innerHTML = "Cart (" + res.data.carttotal + ")";
				document.getElementById("qtyid_" + itemid).innerHTML = res.data.qty;
				document.getElementById("itemprid_" + itemid).innerHTML = "Price: RM " + res.data.itemprice;
				document.getElementById("totalpaymentid").innerHTML = "Total Amount Payable: RM " + res.data.totalpayable;
			} else {
				alert("Failed");
			}

		}
	});
}

function removeCart(itemid, item_price) {
	jQuery.ajax({
		type: "GET",
		url: "mycartajax.php",
		data: {
			itemid: itemid,
			submit: 'remove',
			itemprice: item_price
		},
		cache: false,
		dataType: "json",
		success: function(response) {
			var res = JSON.parse(JSON.stringify(response));
			if (res.status = "success") {
				console.log(res.data.carttotal);
				var itemid = res.data.itemid;
				document.getElementById("carttotalida").innerHTML = "Cart (" + res.data.carttotal + ")";
				document.getElementById("carttotalidb").innerHTML = "Cart (" + res.data.carttotal + ")";
				document.getElementById("qtyid_" + itemid).innerHTML = res.data.qty;
				document.getElementById("itemprid_" + itemid).innerHTML = "Price: RM " + res.data.itemprice;
				document.getElementById("totalpaymentid").innerHTML = "Total Amount Payable: RM " + res.data.totalpayable;
				console.log(res.data.qty);
				if (res.data.qty==null){
				    var element = document.getElementById("itemcard_"+itemid);
				    element.parentNode.removeChild(element);
				}
			} else {
				alert("Failed");
			}

		}
	});
}
</script>
</body>
</html>
<!--// <a href='mycart.php?useremail=$useremail&itemid=$itemid&qty=$item_qty&submit=remove' class='w3-btn w3-blue w3-round'>-</a>-->
<!--     // $item_qty-->
<!--     // <a href='mycart.php?useremail=$useremail&itemid=$itemid&qty=$item_qty&submit=add' class='w3-btn w3-blue w3-round'>+</a><br>-->
