<?php 
session_start(); 
require_once('config/MongoDB.php'); 
  $db = new MongoDB(); 
if($_GET['key'] == 'like'){
    $user = $_GET['username'];
    $post_id = $_GET['id']; 
    if ($db->likePost($user, $post_id)){
      $db->deleteLike($user, $post_id);
    }else{
      $db->addLike($user, $post_id); 
    }
    echo '{' ; 
    echo '"likes" : '; 
    echo $db->likeNumber($post_id) ; 
    echo '}'; 
  }elseif($_GET['key']=='index'){
    $allPosts = $db->getPost(10);
    $myPosts = [];
    foreach($allPosts as $post){
      array_push($myPosts, $post);
    }
    echo json_encode($myPosts); 
  }
?>