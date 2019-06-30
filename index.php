<?php
    require_once('./config/MongoDB.php'); 

    $db = new MongoDB();
    
    $task = "" ;
    
    if(array_key_exists("task", $_GET)){
        $task = $_GET['task'];
    }
    if($task == 'logout'){
        session_start();
        session_destroy();
    }
    if (isset($_POST["submit"])){
        $db->setPost($_POST, $_FILES) ; 
    }
    require('views/index.view.php') ; 

?>