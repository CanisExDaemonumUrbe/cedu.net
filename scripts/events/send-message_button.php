<?php
    include '../extensions/db_connect.php';
    include '../extensions/session.php';

    my_session_start();

    $login = $_GET['login'];
    $message = $_POST['message'];
    $date = date("d.m.Y H:i:s");

    $query = "INSERT INTO guestbook SET author='$login', message='$message', date='$date'";
    $link->query($query);


    header('location: /index.php');
?>