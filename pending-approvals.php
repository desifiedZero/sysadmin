<?php 
    session_start();
    $page = "Pending Approvals";
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
    
    $sql = "SELECT * FROM `agent_lead` WHERE `approve_status` = 'P'";

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

        } else if ($fromdate != ''){

            $fromdate = strtotime($_GET['fromdate']);
            $todate = strtotime("+1 day", $fromdate);
            $fromdate = date('Y-m-d H:i:s', $fromdate);
            $todate = date('Y-m-d H:i:s', $todate);

        } else if ($todate != '') {
            $fromdate = strtotime($_GET['todate']);
            $todate = strtotime("+1 day", $fromdate);
            $fromdate = date('Y-m-d H:i:s', $fromdate);
            $todate = date('Y-m-d H:i:s', $todate);
        }
        $sql .= " AND `datetime` >= '$fromdate' AND `datetime` < '$todate'";
    }

    $sql .= " ORDER BY `datetime` DESC";
    $result = $conn->query($sql);
    
?>

<div class="container p-5">
    <form action="" method="get">
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
    <form action="update-pending.php" method="post">
        <h2>Pending Lead Count: <span class="thiccc"><?php echo $result->num_rows; ?></span></h2>
        <?php
            if(isset($_GET['done']) && $_GET['done'] != ''){
                echo "<h5 class=\"alert alert-success\">{$_GET['done']} status updated successfully.</h5>";
            }
        ?>
        <table class="table text-center">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Date Time</th>
                <th>Agent ID</th>
                <th>Agent Name</th>
                <th><b>A/P/R</b></th>
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
                        <td>";
                        ?>
                        <div class="toggler-cont">
                            <input type="radio" value="A" class="toggler approve" id="<?php echo $row['id']; ?>_A" name="<?php echo $row['id']; ?>">
                            <label for="<?php echo $row['id']; ?>_A"><span class="fas fa-check"></span></label>
                            <input type="radio" value="P" class="toggler pending" id="<?php echo $row['id']; ?>_P" name="<?php echo $row['id']; ?>" checked>
                            <label for="<?php echo $row['id']; ?>_P"><span class="fas fa-slash"></label>
                            <input type="radio" value="R" class="toggler reject" id="<?php echo $row['id']; ?>_R" name="<?php echo $row['id']; ?>">
                            <label for="<?php echo $row['id']; ?>_R"><span class="fas fa-times"></label>
                        </div>
                        <?php
                        echo "</td>
                    </tr>
                    ";
                }
            } else {}
        ?>
        </table>
        <button type="submit" class="btn btn-success btn-lg btn-block py-3">Update</button>
    </form>
</div>

<?php
include('footer.php');