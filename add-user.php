<?php 
    session_start();
    $page = "Add New User";
    include_once("header.php");

    require('functions.php');
    validate_admin();

    require('dbconfig.php');

    $done = false; $tried = false;
    if(isset($_POST['id']) && isset($_POST['fullname']) && isset($_POST['pass']) && isset($_POST['role'])){
        $id = $_POST['id'];
        $fullname = $_POST['fullname'];
        $password = $_POST['pass'];
        $role = $_POST['role'];
        if($id != '' && $fullname != '' && $password != '' && $role != ''){
            $conn = new mysqli($host, $user, $pass, $db);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $id = $conn -> real_escape_string($id);
            $fullname = $conn -> real_escape_string($fullname);
            $password = $conn -> real_escape_string($password);
            $role = $conn -> real_escape_string($role);
            
            $sql = "INSERT INTO `users` VALUES ('$id', '$fullname', '$password', '$role')";

            if($conn -> query($sql) === TRUE){
                $done = true;
            } else {
                $tried = true;
                $done = false;
            }
        }
    }

    
?>

<div class="container p-5">
    <div class="row">
        <div class="col">
            <h2 class="thicc">Add new User</h2>
            <?php
                if($done){
                    echo "<h5 class=\"alert alert-success\">User Created Successfully</h5>";
                } else if($tried) {
                    echo "<h5 class=\"alert alert-danger\">User Creation Unsuccessful</h5>";
                }
            ?><hr>
            <form action="" method="post">
                <div class="form-group">
                    <label for="id"><span class="text-danger">*</span>User ID</label>
                    <input type="text" name="id" id="id" placeholder="User ID" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fullname"><span class="text-danger">*</span>Full Name</label>
                    <input type="text" name="fullname" id="fullname" placeholder="Full Name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="pass"><span class="text-danger">*</span>Password</label>
                    <input type="password" name="pass" id="pass" placeholder="Password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="role"><span class="text-danger">*</span>Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="csr">CSR Agent</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success btn-lg">Create</button><br>
                <small class="text-secondary">* Passwords are saved in plaintext</small>
            </form>
        </div>
    </div>
</div>

<?php
include('footer.php');