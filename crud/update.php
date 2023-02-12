<?php

require "../connection.php";
require "../model/termin.php";

if (isset($_POST['id']) && isset($_POST['trener']) && isset($_POST['lokacija']) && isset($_POST['datum'])) {

    $status = Termin::update($_POST['id'], $_POST['trener'], $_POST['lokacija'], $_POST['datum'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}
?>