<?php  
  session_start(); 
  include('partials/header.php'); 
//   include('partials/head.php'); 
  require_once('config/MongoDB.php'); 
  
  $db = new MongoDB(); 
  if(isset($_POST['Update'])){
    $user = $db->update_user($_SESSION['username'],$_POST, $_FILES); 
    }
  if(isset($_GET['user'])){
    $user = $db->getUser($_GET['user']);
  }else{
    $user = $db->getUser($_SESSION['username']);
  }
  $myposts = $db->myPost(); 

  if(isset($_GET['update'])){
      $update_profile = TRUE;   
    } 
  include('views/profile.view.php'); 
?>
<?php include('partials/footer.php'); ?>