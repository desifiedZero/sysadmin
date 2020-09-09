<?php 
    if($_SERVER['HTTPS'] != 'on'){
        header("HTTP/1.1 301 Moved Permanently");
    	header("Location: https://igocl.com/sysadmin");
    	exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page; ?></title>
    <link rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" 
        crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<nav class="navbar navbar-expand-lg" style="background: #f1ffdb;">
    <a class="navbar-brand" href="index.php">
        <img src="../images/logo-white.png" alt="" style="max-height: 38px;">
    </a> 
    <?php echo $page; ?>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="logout.php"><button class="btn btn-danger">Logout</button></a>
            </li>
        </ul>
    </div>
</nav>