<?php 
    session_start();
    $page = "Agents";
    include_once("header.php");

    require('functions.php');
    validate_admin();

    require('dbconfig.php');

    $conn = new mysqli($host, $user, $pass, $db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $userid = $_COOKIE['user'];
    
    $sql = "SELECT `id`, `name` FROM `users` WHERE `role`='csr'";

    $sql .= " ORDER BY `name`";
    $result = $conn->query($sql);
    
?>

<div class="container p-5">
    <h2 class="thicc">Agents</h2>
    <hr>
    <div class="">
        <div class="row text-center">
            <div class="col-3">
                <b>Agent ID</b>
            </div>
            <div class="col">
                <b>Agent Name</b>
            </div>
        </div>
        <?php
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                echo    "<a href=\"leads.php?agent=" . $row['id'] . "\" class=\"hovered\">
                            <div class=\"row p-0 text-center py-3\">
                                <div class=\"col-3\">".$row['id']."</div>
                                <div class=\"col\">".$row['name']."</div>
                            </div>
                        </a>";
                }
            } else {}
        ?>
    </div>
</div>

<?php

include('footer.php');