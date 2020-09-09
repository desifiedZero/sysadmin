<?php
    session_start();
    require('functions.php');
    if(isset($_COOKIE['user']) && isset($_COOKIE['role'])){
        renew_session();
    } else {
        header("Location: login.php");
    }

    if($_COOKIE['role'] == 'csr') {
        header("Location: agent-dash.php");
    }
    if($_COOKIE['role'] == 'admin') {
        header("Location: admin-dash.php");
    }
?>