<?php
require "../connection.php";
require  "../model/termin.php";

if(isset($_POST['id'])){
    
    $status = Termin::deleteById($_POST['id'], $conn);
    if($status){
        echo 'Success';
    }else{
        echo 'Failed';
    }
}
?>
