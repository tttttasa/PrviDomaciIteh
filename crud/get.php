<?php

require "../connection.php";
require "../model/termin.php";

if(isset($_POST['id'])) {
    $myArray = Termin::getById($_POST['id'], $conn);
    echo json_encode($myArray);
}
?>