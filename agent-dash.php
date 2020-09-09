<?php 
    session_start();
    $page = "Agent Dashboard";
    include_once("header.php");

    require('functions.php');
    validate_csr();

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

    $monthcount = $conn->query("SELECT count(*) as 'count' FROM `leads` 
    WHERE MONTH(`datetime`) = MONTH(CURDATE()) 
    AND YEAR(`datetime`) = YEAR(CURDATE()) 
    AND `agent_id` = '$userid'");

    if($monthcount -> num_rows > 0) {
        $counter = $monthcount -> fetch_assoc();
        $month = $counter['count'];
    }

    $yearcount = $conn->query("SELECT count(*) as 'count' FROM `leads` 
    WHERE YEAR(`datetime`) = YEAR(CURDATE())
    AND `agent_id` = '$userid'");

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
            <h3 class="thin">Agent ID: <span class="thicc"><?php echo $userid; ?></span></h3>
            <h3 class="thin">Agent Name: <span class="thicc"><?php echo $username; ?></span></h3>
            <hr>
        </div>
    </div>
    
    <div class="row text-center">
        <div class="col-12 text-left"><h2 class="thiccc text-success">Leads</h2></div>
        <div class="col">This Month<br><h3 class="thiccc"><?php echo isset($month) ? $month : 0; ?></h3></div>
        <div class="col">This year<br><h3 class="thiccc"><?php echo isset($year) ? $year : 0; ?></h3></div>
        <div class="col">Overall<br><h3 class="thiccc"><?php echo $result->num_rows; ?></h3></div>
    </div>
    <hr class=""><br>
    <div class="row">
        <div class="col-md-4">
            <form action="new-lead.php" id="newlead" onsubmit="newlead(event)" class="bg-success text-light p-3 sticky-top rounded">
                <h2 class="thicc">Enter new lead</h2>
                <div class="form-group">
                    <label for="leadname">Lead Name</label>
                    <input type="text" id="leadname" name="leadname" class="form-control" placeholder="Lead Name">
                </div>
                <div class="form-group">
                    <label for="leadphone">Lead Phone</label>
                    <input type="text" id="leadphone" name="leadphone" class="form-control" placeholder="Lead Phone">
                </div>
                <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                <button type="submit" class="btn btn-light">Submit</button>
            </form>
        </div>
        <div class="col-md-8">
            <h2 class="thicc">Previous Leads</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Date Time</th>
                    </tr>
                </thead>
                <tbody id="leads">
                <?php
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>".$row['name']."</td>
                            <td>".$row['phone']."</td>
                            <td>";
                            if ($row['approve_status'] == 'P'){
                                echo 'Pending';
                            } elseif ($row['approve_status'] == 'A') {
                                echo 'Approved';
                            } else {
                                echo 'Rejected';
                            }
                            echo "</td>
                            <td>".$row['datetime']."</td>
                        </tr>
                        ";
                    }
                } else {}
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
$conn -> close();
    include_once("footer.php");
?>