<?php
    include './scripts/extensions/db_connect.php';
    include './scripts/extensions/session.php';

    my_session_start();
    my_session_set('status', null);
    my_session_set('auth', 0);

    header("Refresh: 3;url=./index.php");
?>
