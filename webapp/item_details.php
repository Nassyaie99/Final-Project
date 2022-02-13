<?php
include_once ("dbconnect.php");
$item_id = $_GET['item_id'];
$sqlquery = "SELECT * FROM tbl_product WHERE item_id = $item_id";
$stmt = $conn->prepare($sqlquery);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

foreach ($rows as $product)
{
    $id = $product['id'];
            $title = $product['title'];
            $description = $product['description'];
            $price = $product['price'];
}
?>


<!DOCTYPE html>
<html>
<title>Muaz Photography</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<script src="../js/script.js"></script>

<body>
    <!-- Sidebar (hidden by default) -->
    <nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button">Close Menu</a>
        <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button">Products</a>
        <a href="mycart.php" onclick="w3_close()" class="w3-bar-item w3-button">Carts</a>
        <a href="mypayment.php" onclick="w3_close()" class="w3-bar-item w3-button">Payment</a>
        <a href="about.php" onclick="w3_close()" class="w3-bar-item w3-button">About</a>
        <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button">Logout</a>
    </nav>

    <!-- Top menu -->
    <div class="w3-top">
        <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
            <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
            <div class="w3-right w3-padding-16">Mail</div>
            <div class="w3-center w3-padding-16">Muaz Photography</div>
        </div>
    </div>
    
    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
      
      <div class="w3-row w3-card">
        <div class="w3-half w3-center">
            <img class="w3-image w3-margin w3-center" style="height:100%;width:100%;max-width:330px" src="../images/items/<?php echo $item_isbn?>.jpg">
        </div>
        <div class="w3-half w3-container">
            <?php 
            echo "<h3 class='w3-center'><b>$item_title</h3></b>
            <p>Description<br>$item_description</p>
            <p style='font-size:160%;'>RM $item_price</p>
            <p> <a href='index.php?item_id=$item_id' class='w3-btn w3-blue w3-round'>Add to Cart</a><p><br>
            <p>Date added<br>$item_date</p>
            ";
            
            ?>
        </div>
        </div>
    </div>
    </div>
    <footer class="w3-row-padding w3-padding-32">
        <p class="w3-center">MUAZ PHOTOGRAPHY&reg;</p>
    </footer>
   

</body>

</html>
