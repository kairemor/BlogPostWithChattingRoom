<?php
     require_once('./config/MongoDB.php'); 

     $db = new MongoDB(); 
     // var_dump($_POST) ;
     if (isset($_POST['submit'])){
         $db->login($_POST) ; 
     }
     
    include('views/login.view.php') ;
?>
