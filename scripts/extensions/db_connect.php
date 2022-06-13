<?php
    $host = 'localhost';
    $user = 'CEDU';
    $password = 'gfhjkm';
    $db_name = 'socialnetwork';

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $link = new mysqli($host, $user, $password, $db_name);
    if ($link->connect_error) {
        die($link->connect_error);
    }

    mysqli_query($link, "SET NAMES 'utf8'");
?>