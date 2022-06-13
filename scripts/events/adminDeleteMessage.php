<?php
    include '../extensions/db_connect.php';
    include '../extensions/session.php';

    my_session_start();

    $messageId = $_GET['id'];

    $query = "DELETE FROM guestbook WHERE id='$messageId'";

    $link->query($query);

    header('location: /index.php');

?>