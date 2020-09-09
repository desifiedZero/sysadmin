<?php
session_start();

if( isset($_COOKIE['user']) && 
    isset($_POST['leadname']) &&
    isset($_POST['leadphone']) &&
    isset($_POST['userid']) &&
    $_POST['userid'] == $_COOKIE['user']
    ){

    if(is_numeric($_POST['leadphone'])){

        require('dbconfig.php');
        $conn = new mysqli($host, $user, $pass, $db);
        
        if ($conn -> connect_error) {
            die("Connection failed: " . $conn -> connect_error);
        }

        $name = $conn -> real_escape_string($_POST['leadname']);
        $phone = $conn -> real_escape_string($_POST['leadphone']);
        $userid = $conn -> real_escape_string($_POST['userid']);
        
        $sql = "INSERT INTO leads (name, phone, agent_id)
        VALUES ('$name', '$phone', '$userid')";
        
        if ($conn -> query($sql) === TRUE) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        
        $conn -> close();
        
        if(http_response_code() == 200){
            header('Content-Type: application/json');
            echo json_encode(array(
                'ok' => true,
                'timestamp' => date('Y-m-d H:i:s'),
                'leadName' => $name,
                'leadPhone' => $phone,
                'status' => 'Pending'
            ));
        } else {
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('error' => "Agent ID $userid does not match to any in the system")));
        }

    } else {
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('error' => 'Lead Number is not numeric')));
    }

} else {
    header('HTTP/1.1 400 Bad Request');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array(
        'error' => 'Incomplete or mismatched information. Please check again.',
        'cookie' => $_COOKIE['user'],
        'name' => $_POST['leadname'],
        'phone' => $_POST['leadphone'],
        'user' => $_POST['userid'],
        'cookieall' => json_encode($_COOKIE)
    )));
}

