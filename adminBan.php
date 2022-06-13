<?php
    include './scripts/extensions/db_connect.php';
    include './scripts/extensions/session.php';

    my_session_start();

    $userId = $_GET['id'];
    $userBanStatus = $_GET['status'];

    $query;

    if($userBanStatus == '0') {
        $query = "UPDATE users SET banned='1' WHERE id='$userId'";
    } else if($userBanStatus == '1') {
        $query = "UPDATE users SET banned='0' WHERE id='$userId'";
    }

    $link->query($query);

    header("Refresh: 0.1;url=./admin.php");
?>