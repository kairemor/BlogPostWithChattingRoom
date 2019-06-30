<?php 
    session_start(); 
    require_once('config/MongoDB.php'); 
    
    $db = new MongoDB(); 

    echo json_encode($db->mostView()); 

?>