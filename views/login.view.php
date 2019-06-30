<?php 
    include('partials/header.php'); 
    include('partials/head.php'); 
    session_start(); 
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div id="login" class="col-ml-9 mt-6">
        <div class="card card-body">
            <form class="form" method="POST" action="login.php">
                
                <h2 class="text-center" > <i class="fas fa-user-alt    "></i> Log in your account</h2>
                <label class="control-label" for="username">Username</label>
                <?php session_start(); if(isset($_SESSION['username_login_err'])) {echo'<div class="text-danger"> '.$_SESSION['username_login_err']. '</div>';} ?>
                <input class="form-control" id="username" type="text" name="username">

                <label  class="control-label" for="passport">Password</label>
                <?php session_start(); if(isset($_SESSION['pwd_login_err'])) {echo'<div class="text-danger"> '.$_SESSION['pwd_login_err']. '</div>' ;} ?>
                <input  class="form-control" type="password" name="password" id="password">

                <input class="btn btn-secondary btn-block mt-2" name="submit" type="submit" value="Sign In">
            </form>  
        </div> 
        </div>
    </div> 
</div>


<?php include('partials/footer.php'); ?>

