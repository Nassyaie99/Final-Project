<?php
include_once("dbconnect.php");
session_start();

if (isset($_SESSION['sessionid'])) {
    $useremail = $_SESSION['user_email'];
}else{
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    return;
}
if (isset($_GET['submit'])) {
    $itemid = $_GET['itemid'];
    $itemprice = $_GET['itemprice'];
    $sqlqty = "SELECT * FROM tbl_carts WHERE user_email = '$useremail' AND item_id = '$itemid'";
    $stmtsqlqty = $conn->prepare($sqlqty);
    $stmtsqlqty->execute();
    $resultsqlqty = $stmtsqlqty->setFetchMode(PDO::FETCH_ASSOC);
    $rowsqlqty = $stmtsqlqty->fetchAll();
    $itemcurqty = 0;
    foreach ($rowsqlqty as $items) {
        $itemcurqty = $items['cart_qty'] + $itemcurqty;
    }
    if ($_GET['submit'] == "add"){
        $cartqty = $itemcurqty + 1 ;
        $updatecart = "UPDATE `tbl_carts` SET `cart_qty`= '$cartqty' WHERE user_email = '$useremail' AND item_id = '$itemid'";
        $conn->exec($updatecart);
    }
    if ($_GET['submit'] == "remove"){
        if ($itemcurqty == 1){
            $updatecart = "DELETE FROM `tbl_carts` WHERE user_email = '$useremail' AND item_id = '$itemid'";
            $conn->exec($updatecart);
        }else{
            $cartqty = $itemcurqty - 1 ;
            $updatecart = "UPDATE `tbl_carts` SET `cart_qty`= '$cartqty' WHERE user_email = '$useremail' AND item_id = '$itemid'";
            $conn->exec($updatecart);    
        }
    }
}


$stmtqty = $conn->prepare("SELECT * FROM tbl_carts INNER JOIN tbl_product ON tbl_carts.item_id = tbl_product.item_id WHERE tbl_carts.user_email = '$useremail'");
$stmtqty->execute();
//$resultqty = $stmtqty->setFetchMode(PDO::FETCH_ASSOC);
$rowsqty = $stmtqty->fetchAll();
$totalpayable = 0;
foreach ($rowsqty as $carts) {
   $carttotal = $carts['cart_qty'] + $carttotal;
   $itempr = $carts['item_price'] * $carts['cart_qty'];
   $totalpayable = $totalpayable + $itempr;
}

$mycart = array();
$mycart['carttotal'] =$carttotal;
$mycart['itemid'] =$itemid;
$mycart['qty'] =$cartqty;
$mycart['itemprice'] = bcdiv($cartqty * $itemprice,1,2);
$mycart['totalpayable'] = bcdiv($totalpayable,1,2);


$response = array('status' => 'success', 'data' => $mycart);
sendJsonResponse($response);


function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
?>