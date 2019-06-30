<header class="masthead" style="background-image: url('<?php echo $user->image ?>')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <?php
                        session_start();
                        echo '<h2 class="mt-5" align="center">' .$user->firstname. '</h2>' ; 
                        if($_SESSION['username'] == $user->username ){
                            echo '
                            <h1>' .$user->firstname.' </h1>
                            <span class="subheading"> Vous etes dans votre profile </span> ' ; 
                        }else{
                            echo '
                            <h1>' .$user->firstmane.' </h1>
                            <span class="subheading"> Vous etes dans le profile  de ' .$user->firstname.' </span> ' ;
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="row">
    <div class="otherpost col-md-6 container">
        <?php 
            if($_SESSION['username'] == $user->username){
                echo '
                    <h3>Vos publications</h3>
                ';
            }else{
                echo '
                <h3> Publications de ' .$user->username.'</h3>
                ';
            }
        ?>
        <hr>
        <?php
    foreach($myposts as $post){
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
    <div class="col-md-5">
        <?php
            if($_SESSION['username'] == $user->username){
                echo '
                    <a class="btn btn-success" href="profile.php?update=photo&#update_profile">modifier votre profile</a>
                ';
                }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>Prenom : <?php echo $user->firstname ?></p>
                    <p>Nom : <?php echo $user->lastname ?></p>
                    <p>Email : <?php echo $user->email ?></p>
                </div>
                <div class="col-md-6 image_profile">
                    <img width="200" height="200" src="<?php echo $user->image ?>" alt="Pas de photo profile">
                </div>
            </div>
            <?php if ($update_profile ){
            echo '
                <div  class="container mt-5 ml-auto">
                    <div class="card card body" style="padding:5px">
                        <div class="row justify-content-center">
                            <div id="register" class="col-md-6 mt-5">
                            
                                <form id="update_profile" class="form" method="POST" action="profile.php"  enctype="multipart/form-data">
                                    <h2 class="text-center">Modifier votre compte</h2>
                                        <label class="control-label" for="fisrtName">Prenom</label>
                                        <input class="form-control" id="fisrtName" type="text" name="firstname" required value="'.$user->firstname.'">
                                        
                                        <label class="control-label" for="lastname">Nom</label>
                                        <input class="form-control" id="lastname" type="text" name="lastname" required value="'.$user->lastname.'">

                                        <label for="image"> Photo de profile </label>
                                        <input  class="form-inline mb-2" type="file" name="image" id="image ">
                                        <input class="btn btn-primary btn-block  mt-2 ml-auto" type="submit" name="Update" value="Update">
                                </form> 
                            </div>
                        </div>   
                    </div>
                </div>
            ';
        }?>
        </div>
    </div>
</div>