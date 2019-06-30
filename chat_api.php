<?php
    session_start(); 
    require('./config/MongoDB.php'); 
    $db = new MongoDB(); 
    $task = "list" ;
    
    if(array_key_exists("task", $_GET)){
        $task = $_GET['task'];
    }
    if($task == 'write'){
        postMessage();
    }else{
        getMessage();
    }

    function getMessage(){
        global $db;
        $message = $db->getMessages();
        $messages = [] ; 
        foreach($message as $msg){
            array_push($messages, $msg);
        }
        echo json_encode($messages);
    }

    function postMessage(){
        global $db ;
        if (!array_key_exists('message', $_POST)){
            echo json_encode(['status' => 'error' , 'message' => 'Le message ne doit pas etre vide']);
            return 1; 
        }
        $db->setMessage($_POST);     
        echo json_encode(['status' => 'success']);
    }
?>