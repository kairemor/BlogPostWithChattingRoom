<?php 
  session_start(); 
  include('partials/header.php'); 
  require_once('config/MongoDB.php'); 
  $db = new MongoDB(); 

  $post_id = $_GET['id']; 
  if( isset($_POST['id']) ){
    $post_id = $_POST['id']; 
  }; 
  $post = $db->getOne($post_id);

  $view_number = $db->addView($post_id);
  if(isset($_GET['confirm_delete'])){
      $db->deletePost($post_id);
      header("Location: /index.php") ; 
  }
  if(isset($_GET['setComment'])){
      $db->addComment($post_id, $_GET); 
  }

  if (isset($_POST['update_post'])){
    $post_id = $_POST['id'];
    $db->updatePost($post_id, $_POST, $_FILES); 
    header("Location: /single.php?id=".$post_id) ; 
  }
  $comments = $db->getComments($post_id);
  $like_number = $db->likeNumber($post_id);
  $posts = $db->getPost(3); 
  if (isset($_GET['key'])){
    if ($_GET['key'] == 'update'){
      $update = TRUE ; 
    }
    elseif ($_GET['key'] == 'delete') {
        $delete_confirm = TRUE; 
    }
  }
  include('views/single.view.php');
?>
