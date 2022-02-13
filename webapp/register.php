<?php
session_start();
if (!isset($_SESSION['sessionid'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}
if (isset($_POST["submit"])) {
    include_once("dbconnect.php");
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pass = sha1($_POST["password"]);
    
    $sqlregister = "INSERT INTO `tbl_admin`(`name`, `email`, `password`) VALUES('$name', '$email', '$pass')";
    try {
        $conn->exec($sqlregister);
        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            
        }
        echo "<script>alert('Registration successful')</script>";
        echo "<script>window.location.replace('login.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Registration failed')</script>";
        echo "<script>window.location.replace('register.php')</script>";
    }
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
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <script src="../javascript/script.js"></script>
    <title>Muaz Photography</title>
</head>

<body>
    <div class="w3-header w3-container w3-black w3-padding-32 w3-center">
        <h1 style="font-size:calc(8px + 4vw);">MUAZ PHOTOGRAPHY</h1>
        
    </div>

    <div class="w3-container">
    <div class="w3-display-container mySlides">
      <img src="img/DSC02679.JPG" style="width:100%">
      <div class="w3-display-topleft w3-container w3-padding-32">
        <span class="w3-white w3-padding-large w3-animate-bottom">WEDDING</span>
      </div>

    <div class="w3-container w3-padding-64 form-container">
        <div class="w3-card">
            <div class="w3-container w3-black">
                <p>New Registration
                <p>
            </div>
            <form class="w3-container w3-padding" name="registerForm" action="register.php" method="post" enctype="multipart/form-data" onsubmit="return confirmDialog()" >
                
                <p>
                    <label>Name</label>
                    <input class="w3-input w3-border w3-round" name="name" id="idname" type="text" required>
                </p>

                <p>
                    <label>Email</label>
                    <input class="w3-input w3-border w3-round" name="email" id="idemail" type="email" required>
                </p>
                <p>
                    <label class="w3-text-black"><b>Password</b></label>
                    <input class="w3-input w3-border w3-round" name="password" type="password" id="idpass" required>
                </p>

                <div class="row">
                    <input class="w3-input w3-border w3-block w3-green w3-round" type="submit" name="submit" value="Submit">
                </div>

            </form>


        </div>
    </div>

    <footer class="w3-footer w3-center w3-blue-grey">
        <p>Muaz Photography</p>
    </footer>

</body>

</html>