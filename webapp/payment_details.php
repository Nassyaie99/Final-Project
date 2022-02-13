<?php
include_once ("dbconnect.php");
session_start();
if (isset($_SESSION['sessionid']))
{
    $useremail = $_SESSION['user_email'];
}else{
    echo "<script>alert('Please login or register')</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

$receiptid = $_GET['receipt'];
$sqlquery = "SELECT * FROM tbl_orders INNER JOIN tbl_product ON tbl_orders.order_itemid = tbl_product.item_id WHERE tbl_orders.order_receiptid = '$receiptid'";
$stmt = $conn->prepare($sqlquery);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

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
<title>Afira Herbs</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<script src="../js/script.js"></script>

<body>
    <!-- Sidebar (hidden by default) -->
    <nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:20%;min-width:200px" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button">Close Menu</a>
        <a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button">Login</a>
        <a href="register.php" onclick="w3_close()" class="w3-bar-item w3-button">Register</a>
        <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button">Product</a>
        <a href="mycart.php" onclick="w3_close()" class="w3-bar-item w3-button">Carts</a>
        <a href="mypayment.php" onclick="w3_close()" class="w3-bar-item w3-button">Payment</a>
        <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button">Logout</a>
    </nav>

    <!-- Top menu -->
    <div class="w3-top">
        <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
            <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
            
            <div class="w3-center w3-padding-16">Muaz Photography</div>
            <hr>
        </div>
    </div>
    
    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
      
      <div class="w3-grid-template">
          
          <?php 
            $totalpaid = 0.0;
           foreach ($rows as $details)
            {
                $itemid = $details['item_id'];
                $item_title = subString($details['item_title']);
                $order_qty = $details['order_qty'];
                $order_paid = $details['order_paid'];
                $order_status = $details['order_status'];
                $totalpaid = ($order_paid * $order_qty) + $totalpaid;
                $item_isbn = $details['item_isbn'];
                $order_date = date_format(date_create($details['order_date']), 'd/m/y h:i A');
               echo "<div class='w3-center w3-padding-small'><div class = 'w3-card w3-round-large'>
                    <div class='w3-padding-small'><img class='w3-container w3-image' 
                    src=../images/items/$item_isbn.jpg onerror=this.onerror=null;this.src='../images/items/default.jpg'></a></div>
                    <b>$item_title</b><br>RM $order_paid<br> $order_qty unit<br></div></div>";
             }
             
             $totalpaid = number_format($totalpaid, 2, '.', '');
            echo "</div><br><hr><div class='w3-container w3-left'><h4>Your Order</h4><p>Order ID: $receiptid<br>Name: $user_name Total Paid: RM $totalpaid<br>Status: $order_status<br>Date Order: $order_date<p></div>";
            ?>
    </div>
    
    <footer class="w3-row-padding w3-padding-32">
        <hr>
        <p class="w3-center">MUAZ PHOTOGRAPHY&reg;</p>
    </footer>
   

</body>

</html>
