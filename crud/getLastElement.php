<?php
require "../connection.php";
require "../model/termin.php";


$status = Termin::getLast($conn);

if($status){
  //$result = array("id", "trener", "lokacija", "datum");
   $result = $status->fetch_assoc();
  echo json_encode($result);
 // echo $status->fetch_column();
} else {
    echo $status;
    echo 'Failed';
}
