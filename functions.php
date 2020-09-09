<?php 

function validate_admin() {
    if(isset($_COOKIE['user']) && isset($_COOKIE['role'])){
        renew_session();
        if($_COOKIE['role'] != 'admin'){
            header("Location: index.php");
        }
    } else {
        header("Location: login.php");
    }
}

function validate_csr() {
    if(isset($_COOKIE['user']) && isset($_COOKIE['role'])){
        renew_session();
        if($_COOKIE['role'] != 'csr'){
            header("Location: index.php");
        }
    } else {
        header("Location: login.php");
    }
}

function renew_session() {
    setcookie('user', $_COOKIE['user'], time() + 3600);
    setcookie('role', $_COOKIE['role'], time() + 3600);
}