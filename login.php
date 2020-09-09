<?php 
    $page = "Login";
    include_once("header.php");

    if(isset($_COOKIE['user']) && isset($_COOKIE['role'])){
        header("Location: index.php");
    } else {

    }
?>

<script>
    document.querySelector('nav').remove();
</script>
    
<div class="container-fluid h-100">
    <div class="row h-100 justify-content-center text-center align-content-center">
        <div class="col-md-4 col-sm-8 float-box">
            <form action="validate.php" method="post">
                <h2 class="thiccc">Login</h2>
                <?php if(isset($_GET['mismatch']) && $_GET['mismatch'] == 1) {?>
                
                <div class="alert alert-danger">Username or password incorrect</div>

                <?php } ?>
                <hr>
                <div class="form-group text-left">
                    <label for="id">User ID</label>
                    <input type="text" name="id" id="id" class="form-control" placeholder="User ID">
                </div>
                <div class="form-group text-left">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg thicc">LOGIN</button>
                    <br>
                    <small><a href="#">Forgot your password?</a></small>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
    include("footer.php");
?>