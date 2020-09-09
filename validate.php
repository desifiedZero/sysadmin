<?php
    session_start();
    require('functions.php');

    require('dbconfig.php');
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn -> connect_error) {
        die("Connection failed: " . $conn -> connect_error);
    }

    $userid = $conn -> real_escape_string($_POST['id']);
    $password = $conn -> real_escape_string($_POST['password']);

    $sql = "SELECT `id`, `role` FROM users WHERE `id` = '$userid' AND `password` = '$password'";

    $result = $conn -> query($sql);

    if($result -> num_rows > 0){
        $row = $result -> fetch_assoc();
        setcookie('user', $row['id'], time() + 3600);
        setcookie('role', $row['role'], time() + 3600);
        $conn -> close();
        $loc = $row['role'] == 'csr' ? agent : $row['role'];
        header("Location: ". $loc ."-dash.php");
    } else {
        header("Location: login.php?mismatch=1");
    }