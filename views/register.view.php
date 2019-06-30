<?php include('partials/header.php'); 
    include('partials/head.php'); 

    session_start() ; 
    echo '<div class="text-danger" align="center">'.$_SESSION["register_username"]. '</div>'  ; 
    echo '<div class="text-danger" align="center">'.$_SESSION['register_pwd_match']. '</div>'; 
    session_abort() ; 

?>

<div class="container mt-5 ml-auto">
    <div class="row justify-content-center">
       <div id="register" class="col-md-6 mt-5">
         <div class="card card-body">
            <h1 class="text-center mb-3">
                <i class="fas fa-user-plus"></i> Register
            </h1>
        <form class="form" method="POST" action="register.php">
            <div class="form-group">
                <label class="control-label" for="fisrtName">First Name</label>
                <input class="form-control" id="fisrtName" type="text" name="firstname"  required placeholder="Yatta">
             </div>

            <div class="form-group">
                <label class="control-label" for="lastname">Last Name</label>
                <input class="form-control" id="lastname" type="text" name="lastname" required placeholder="gaye">
            </div>

            <div class="form-group">
                <label class="control-label" for="username">Username</label>
                <input class="form-control" id="username" type="text" name="username" required placeholder="gayeyatta">
            </div>

            <div class="form-group">
                <label class="control-label" for="email">Email</label>
                <input class="form-control" id="email" type="email" name="email" required placeholder="gaye@example.com">
            </div>

            <div class="form-group">
                <label class="control-label" for="password">Password</label>
                <input class="form-control" id="password" type="password" required name="password">
            </div>

            <div class="form-group">
                <label  class="control-label" for="confirmPassword">Confirm Password</label>
                <input  class="form-control" type="password" name="confirmPassword" required id="confirmPassword">
            </div>

            <input class='btn btn-primary btn-block  mt-2 ml-auto' type="submit" name="register" value="Register">
            
            Tu as deja un compte ? <a href="login.php" class="alert-danger mt-2"><i class="fas fa-sign-in-alt"></i> Login</a>
        </form> 
       </div>
       </div>
    </div>   
</div>

<script>
    var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirmPassword");

    function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>

<?php include('partials/footer.php'); ?>

