<?php
    require_once('./config/MongoDB.php'); 

    $db = new MongoDB(); 
    // var_dump($_POST) ;
    if (isset($_POST['register'])){ 
        $db->register($_POST) ; 
    }
    
    include('views/register.view.php');
?>