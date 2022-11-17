<?php

require "connection.php";
require "model/user.php";

session_start();

if(isset($_POST['username']) && isset($_POST['password'])){
    $uname = $_POST['username'];
    $upass = $_POST['password'];

    //kreiramo korisnika
    $korisnik = new User(1,$uname,$upass);
   // $odg = $korisnik->logInUser($uname,$upass, mysqli);
   $odg = User::logInUser($korisnik, $conn); //staticki pristup preko klase

   if($odg->num_rows==1){
    echo `
    <script>
    console.log("Uspesno ste se prijavili");
    </script>`;
    $_SESSION['user_id'] = $korisnik->id;
    header('Location: welcome.php');
    exit();
   }
   else{
    echo `
    <script>
    console.log("Morate da se prijavite");
    </script>`;
    exit();
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet--->
    <link rel="icon" href="css/images/balance.png" />
    <link rel="stylesheet" href="css/mainpage.css">
    <title>Balance club gym</title>
</head>

<body>
    <div class="login-form">
        <div class="main-div">
            <form method="POST" action="#">
                <h1>Balance club gym</h1>
                <div class="imgcontainer">
                    <img src="css/images/balance.png" style="width:180px; height: 180px;">
                </div>
                <div class="container">
                    <input type="text" placeholder="Username" name="username" class="form-control" required>
                    <br>
                    <input type="password" placeholder="Password" name="password" class="form-control" required>
                    <br>
                    <button class="btn" type="sumbit">Prijavi se</button>
                </div>
            </form>
        </div>
</body>

</html>