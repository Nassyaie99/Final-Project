<?php

if (isset($_POST["submit"])) {
    include_once("dbconnect.php");
    $id = $_POST["id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
   

    $sqlregister = "INSERT INTO `tbl_product`( `id`, `title`, `description`, `price`) VALUES('$id','$title', '$description','$price')";
    try {
        $conn->exec($sqlregister);
        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            uploadImage($id);
        }
        echo "<script>alert('Registration successful')</script>";
        echo "<script>window.location.replace('mainpage.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Registration failed')</script>";
        echo "<script>window.location.replace('addproduct.php')</script>";
    }
}

function uploadImage($id)
{
    $target_dir = "res/images/";
    $target_file = $target_dir . $id . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <script src="javascript/script.js"></script>
    <title>Muaz Photography</title>
</head>

<body>

<div class="w3-panel">
<span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Muaz Photography</span>
  <p></p>
</div>
<div class="w3-container">
    <div class="w3-display-container mySlides">
      <img src="img/DSC03304.JPG" style="width:100%">
      <div class="w3-display-topleft w3-container w3-padding-32">
        <span class="w3-white w3-padding-large w3-animate-bottom">Choose Your Desire</span>
      </div>
    </div>

    

    <div class="w3-container w3-padding-64 form-container">
        <div class="w3-card">
            <div class="w3-container w3-black">
                <p>New Product 
                <p>
            </div>
            <form class="w3-container w3-padding" name="registerForm" action="addproduct.php" method="post" enctype="multipart/form-data" onsubmit="return confirmDialog()" >
                <div class="w3-container w3-border w3-center w3-padding">
                    <img class="w3-image w3-round w3-margin" src="res/images/insert.png" style="width:100%; max-width:600px"><br>
                    <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload"><br>
                </div>

                <p>
                    <label>ProductID</label>
                    <input class="w3-input w3-border w3-round" name="id" id="idproduct" type="text" required>
                </p>
                <p>
                    <label>Title</label>
                    <input class="w3-input w3-border w3-round" name="title" id="idtitle" type="text" required>
                </p>
                <p>
                    <label>Description</label>
                    <input class="w3-input w3-border w3-round" name="description" id="iddescription" type="text" required>
                </p>
                <p>
                    <label>Price</label>
                    <input class="w3-input w3-border w3-round" name="price" id="idprice" type="text" required>
                </p>
                
                

                <div class="row">
                    <input class="w3-input w3-border w3-block w3-black w3-round" type="submit" name="submit" value="Submit">
                </div>

            </form>


        </div>
    </div>

    <footer class="w3-footer w3-center w3-black-grey">
        <p>Muaz Photography</p>
    </footer>

</body>

</html>