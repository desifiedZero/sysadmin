<?php 
    session_start();
    $page = "Admin Dashboard";
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
    
    $sql = "SELECT `name`, `phone`, `approve_status`, `datetime` FROM leads WHERE agent_id = '$userid' ORDER BY `datetime` DESC";
    //  die($sql);
    $result = $conn->query($sql);

    $monthcount = $conn->query("SELECT count(*) as 'count' FROM `leads` WHERE MONTH(`datetime`) = MONTH(CURDATE()) AND YEAR(`datetime`) = YEAR(CURDATE())");

    if($monthcount -> num_rows > 0) {
        $counter = $monthcount -> fetch_assoc();
        $month = $counter['count'];
    }

    $yearcount = $conn->query("SELECT count(*) as 'count' FROM `leads` WHERE YEAR(`datetime`) = YEAR(CURDATE())");

    if($yearcount -> num_rows > 0) {
        $counter = $yearcount -> fetch_assoc();
        $year = $counter['count'];
    }

    $userdata = $conn->query("SELECT `id`, `name` FROM `users` WHERE `id` = '$userid'");

    if($userdata -> num_rows > 0) {
        $counter = $userdata -> fetch_assoc();
        $userid = $counter['id'];
        $username = $counter['name'];
    }
    
?>

<div class="container bg-light py-4 px-5">

    <div class="row">
        <div class="col panel">
            <h3 class="thin">Admin ID: <span class="thicc"><?php echo $userid; ?></span></h3>
            <h3 class="thin">Admin Name: <span class="thicc"><?php echo $username; ?></span></h3>
            <hr>
        </div>
    </div>
    
    <div class="row text-center">
        <div class="col-12 text-left"><h2 class="thiccc text-success">Total Leads</h2></div>
        <div class="col">This Month<br><h3 class="thiccc"><?php echo isset($month) ? $month : 0; ?></h3></div>
        <div class="col">This year<br><h3 class="thiccc"><?php echo isset($year) ? $year : 0; ?></h3></div>
    </div>
    <hr class=""><br>
    <div class="row">
        <div class="col">
            <a class="btn btn-success btn-lg btn-block py-5" href="pending-approvals.php">Change Pending Approvals</a>
        </div>
        <div class="col">
            <a class="btn btn-success btn-lg btn-block py-5" href="leads.php">View All Leads</a>
        </div>
        <div class="col">
            <a class="btn btn-success btn-lg btn-block py-5" href="add-user.php">Add new User</a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <a class="btn btn-success btn-lg btn-block py-5" href="agents.php">View All Agents</a>
        </div>
        <div class="col">
        </div>
        <div class="col">
        </div>
    </div>
</div>

<?php 
$conn -> close();
    include_once("footer.php");
?>