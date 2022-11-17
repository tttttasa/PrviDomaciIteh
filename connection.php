<?php

$host = "localhost";
$db = "teretana";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $db);

if($conn->connect_errno){
    exit("Konekcija je neuspesna: " . $conn->connect_errno);
}

?>