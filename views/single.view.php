  <!-- Page Header -->
  <header class="masthead" style="background-image: url('<?php echo "$post->images" ?>')">
      <div class="overlay"></div>
      <div class="container">
          <div class="row">
              <div class="col-lg-8 col-md-10 mx-auto">
                  <div class="post-heading">
                      <h1><?php echo $post->title ?></h1>
                      <h2 class="subheading"><?php echo $post->subtitle ?></h2>
                      <span class="meta">Ecrit par
                          <a href="profile.php?user=<?php echo $post->user ?>"><?php echo $post->user ?></a>
                          le <?php echo $post->create_at ?></span>
                  </div>
              </div>
          </div>
      </div>
  </header>

  <!-- Post Content -->
  <article>
      <div class="container">
          <div class="row">
              <div class="col-lg-8 col-md-10 mx-auto">
                  <?php echo $post->content ; ?>
              </div>
          </div>
      </div>
  </article>
  <div class="emotion">
      <?php if($_SESSION['username']){
        echo '
        <a id="like" href="like_api.php?task=like&id='.$post->_id.'&username='.$post->user.'">
          '.$like_number.' <i class="fas fa-heart">likes</i>
        </a> <br>
        ';
      }else{
        echo 
          $like_number.' <i class="fas fa-heart">likes</i>
          <br>
          ';
      }
      ?>
      <?php echo  ' '.$view_number ?> <i class="fas fa-eye">Vues</i>
  </div>
  <hr>
  <?php if($post->user == $_SESSION['username'] && !$delete_confirm){
    echo '  
    <div align="center" class="editing">
    <a href="single.php?key=update&id='.$post->_id.'#update_post" class="btn btn-primary"> Modifier le post</a>
    <a href="single.php?key=delete&id='.$post->_id.'" class="btn btn-danger"> Supprimer le post</a>
    </div>
    <hr>
    '; }
    if($delete_confirm){
      echo '
      <form align="center" class="form ml-5" action="single.php">
        <input type="hidden" name="id" value='.$post->_id.'>
        <input type="submit" value="Confirmer" name="confirm_delete" class="btn btn-danger">
        <button class="btn btn-success" > Annuler </button>
      </form>
      <hr>
      '; 
      session_abort(); 
    }
    if($update){
      echo '
      <div id="update_post" class="post-create"> 
      <div class="row justify-content-center">
        <div class="row mb-5">
            <form class="form" action="single.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value='.$post->_id.'>
                <input class="form-control mb-2" type="text" name="title" placeholder="Titre de votre annonce" value="'.$post->title.'">
                <input  class="form-control mb-2 "  type="text" name="subtitle" placeholder="Sous titre de votre annonce" value="'.$post->subtitle.'">
                <textarea class="form-control mb-2"   name="content" id="content" cols="50" rows="2" placeholder="Contenu  de votre annonce">'.$post->content.'</textarea>
                <input  class="form-inline mb-2" type="file" name="image" id="image ">
                <input class="btn btn-success btn-block" type="submit" name="update_post" value="Modifier">
            </form>
        </div>
      </div>
    </div>
    <hr>
      '; 
    }
  ?>
  <div class="row" class="comment_field">
      <div class="col-md-6" class="add_comment mb-5">
          <form class="form" action="single.php">
              <input class="form-inline" type="text" name='comment' placeholder="Entrer votre commentaire">
              <input type="hidden" name="id" value="<?php echo $post->_id ?>">
              <input class="btn btn-success" type="submit" name="setComment" value="Commenter">
          </form>
          <div class="container mx-auto mt-2">
              <div class="comment mx-auto mb-2">
                  <div class="card-title"> Les Commentaires
                      <div class="card card-body">
                          <?php
                    foreach($comments as $comment){
                      echo'
                            <span>'.$comment->user. ': 
                              <span class="text_comment"> ' .$comment->comment. ' </span> 
                            </span>';
                    }
                  ?>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="otherpost col-md-6">
          <h3>Dernieres publications</h3>
          <hr>
          <?php
        foreach($posts as $post){
            echo '
            <div class="post-preview">
              <a href="single.php?id='.$post->_id.'">
                <h2 class="post-title">'
                  .$post->title.'
                </h2>
                <h3 class="post-subtitle">'
                  .$post->subtitle.'
                </h3>
              </a>
              <p class="post-meta">Ecrit par
                <a href="#">' .$post->user. '</a>
                le '.$post->create_at.'</p>
            </div>
            <hr>
            '; 
          } 
        ?>
      </div>
  </div>
  <hr>
  <?php include('partials/footer.php'); ?>
  <script>
const getPost = async text => {
            // var data = new FormData();
            // data.append('user', 'kairemor');
            let like_button = document.getElementById("like");
            $("#like").on('click', (e) => {
                let button = $(this);
                e.preventDefault();
                $.ajax({
                    url: 'like_api.php?key=like&id=<?php echo $post->_id ?>&username=<?php echo $_SESSION['username'] ?>',
                    type: "POST",
                    success: ((data) => {
                        let result = JSON.parse(data);
                        like_button.innerHTML = result.likes + " " +
                            '<i class="fas fa-heart">likes </i>'
                    }),
                    error: (err => console.log(err)),
                })
            });
  </script>