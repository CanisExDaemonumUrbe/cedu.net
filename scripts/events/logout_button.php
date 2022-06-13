<?php
    include '../extensions/db_connect.php';
    include '../extensions/session.php';

    my_session_start();
    my_session_set('auth', 0);

    header('location: /login.php');
?>