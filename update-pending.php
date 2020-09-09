<?php

session_start();
require('functions.php');

require('dbconfig.php');
validate_admin();

$conn = new mysqli($host, $user, $pass, $db);

if ($conn -> connect_error) {
    die("Connection failed: " . $conn -> connect_error);
}

$counter = 0;

foreach ($_POST as $key => $value) {
    $sql = "UPDATE `leads` 
            SET `approve_status` = '$value' 
            WHERE id = '$key'";

    if ($conn -> query($sql) === TRUE)
        $counter++;

    unset($value, $key);
}

$conn -> close();

header("Location: pending-approvals.php?done=$counter");
