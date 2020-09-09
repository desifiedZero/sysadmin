<?php 
    session_start();
    $page = "Leads";
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
    
    $sql = "SELECT * FROM `agent_lead`";

    $iswhereadded = false;
    $agent = '';

    if(isset($_GET['agent']) && $_GET['agent'] != ''){
        $agent = $conn -> real_escape_string($_GET['agent']);
        $sql .= " WHERE `agent_id` = '$agent'";
        $iswhereadded = true;
    }

    if(isset($_GET['todate']) && isset($_GET['fromdate'])){
        $todate = strtotime($_GET['todate']);
        $fromdate = strtotime($_GET['fromdate']);

        if ($todate != '' &&
            $fromdate != '') {

            if($fromdate > $todate){
                $tmp = $todate;
                $todate = $fromdate;
                $fromdate = $tmp;
            }
    
            $todate = strtotime("+1 day", $todate);
    
            $fromdate = date('Y-m-d H:i:s', $fromdate);
            $todate = date('Y-m-d H:i:s', $todate);
            if($iswhereadded) {
                $sql .= " AND ";
            } else {
                $sql .= " WHERE ";
            }
            $sql .= "`datetime` >= '$fromdate' AND `datetime` < '$todate'";

        } else if ($fromdate != ''){

            $fromdate = strtotime($_GET['fromdate']);
            $todate = strtotime("+1 day", $fromdate);
            $fromdate = date('Y-m-d H:i:s', $fromdate);
            $todate = date('Y-m-d H:i:s', $todate);
            if($iswhereadded) {
                $sql .= " AND ";
            } else {
                $sql .= " WHERE ";
            }
            $sql .= "`datetime` >= '$fromdate' AND `datetime` < '$todate'";

        } else if ($todate != '') {
            $fromdate = strtotime($_GET['todate']);
            $todate = strtotime("+1 day", $fromdate);
            $fromdate = date('Y-m-d H:i:s', $fromdate);
            $todate = date('Y-m-d H:i:s', $todate);
            if($iswhereadded) {
                $sql .= " AND ";
            } else {
                $sql .= " WHERE ";
            }
            $sql .= "`datetime` >= '$fromdate' AND `datetime` < '$todate'";
        }
    }

    $sql .= " ORDER BY `datetime` DESC";
    $result = $conn->query($sql);
    
?>

<div class="container p-5">
    <form action="" method="get">
        <div class="form-group">
            <input type="text" placeholder="Enter Agent ID" class="form-control" name="agent" value="<?php echo $agent; ?>">
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="fromdate">From Date</label>
                    <input type="date" name="fromdate" id="fromdate" class="form-control">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="todate">To Date</label>
                    <input type="date" name="todate" id="todate" class="form-control">
                </div>
            </div>
            <div class="col-md-2 align-self-center"><button type="submit" class="form-control btn btn-success">Filter</button></div>
        </div>
    </form>
    <hr>
    <h2>Lead Count: <span class="thiccc"><?php echo $result->num_rows; ?></span></h2>
    <a href="#" onclick="javascript:printerDiv('leads')" class="float-right">Print</a>
    <div id="leads">
        <table class="table text-center">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Date Time</th>
                <th>Agent ID</th>
                <th>Agent Name</th>
            </tr>
        </thead>
        <tbody>
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
                            echo 'Apporved';
                        } else {
                            echo 'Rejected';
                        }
                        echo "</td>
                        <td>".$row['datetime']."</td>
                        <td>".$row['agent_id']."</td>
                        <td>".$row['agent_name']."</td>
                    </tr>
                    ";
                }
            } else {}
        ?>
        </table>
    </div>
</div>

<?php

include('footer.php');