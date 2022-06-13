<?php
    include './scripts/extensions/db_connect.php';
    include './scripts/extensions/session.php';

    my_session_start();

    $userId = $_GET['id'];
    $userStatus = $_GET['status'];

    $query;

    if($userStatus == "admin") {
        $query = "UPDATE users SET status_id='1' WHERE id='$userId'";
    } else if($userStatus == "user") {
        $query = "UPDATE users SET status_id='0' WHERE id='$userId'";
    }

    $link->query($query);

    header("Refresh: 0.1;url=./admin.php");
?>
