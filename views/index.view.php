<?php include('partials/header.php');?>
<?php include('partials/head.php');?>


<!-- Main Content -->
<div class="container">
    <div class="row">
        <div id="main_content" class="col-lg-8 col-md-10 mx-auto">
            <?php 
          session_start(); 
          extract($_SESSION) ; 
          if(isset($register)){
            echo '
            <h4 class="text-success" align="center">' .$register. '</h4>' ;
            ;
          }
          
          if(isset($username)){
            echo '
            <div class="card card-body">
                <div class="post-create"> 
                  <div class="row justify-content-center">
                    <div class="row mb-5">
                        <form class="form" action="index.php" method="POST" enctype="multipart/form-data">
                            <input class="form-control mb-2" type="text" name="title" placeholder="Titre de votre annonce">
                            <input  class="form-control mb-2 "  type="text" name="subtitle" placeholder="Sous titre de votre annonce">
                            <textarea class="form-control mb-2"   name="content" id="content" cols="50" rows="2" placeholder="Contenu  de votre annonce"></textarea>
                            <input  class="form-inline mb-2" type="file" name="image" id="image ">
                            <input class="btn btn-success btn-block" type="submit" name="submit" value="Publier">
                        </form>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
            ' ; 
          }
        ?>
            <div class="container">
                <br />
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <form class="card card-sm">
                            <div class="card-body row no-gutters align-items-center">
                                <div class="col-auto">
                                    <i class="fas fa-search h4 text-body"></i>
                                </div>
                                <!--end of col-->
                                <div class="col">
                                    <input class="form-control form-control-lg form-control-borderless" type="search"
                                        id="search" placeholder="Entrer le jour a chercher">
                                </div>
                                <!--end of col-->
                                <div class="col-auto">
                                    <button class="btn btn-lg btn-success" type="submit">Search</button>
                                </div>
                                <!--end of col-->
                            </div>
                        </form>
                    </div>
                    <!--end of col-->
                </div>
            </div>
            <div id="content">
                <?php
                foreach($db->getPost(10) as $post){
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
                      <a href="profile.php?user='.$post->user. '">' .$post->user. '</a>
                      le '.$post->create_at.'</p>
                  </div>
                  <hr>
                  '; 
                }
              ?>
                <hr>
            </div>
            <!-- Pager -->
            <div class="clearfix">
                <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
            </div>
        </div>
    </div>
</div>

<hr>


<?php include('partials/footer.php');  ?>
<script>
const search = document.getElementById('search');
var content = document.getElementById('content');
const getPost = async text => {
    const result = await fetch('like_api.php?key=index')
    const results = await result.json()

    let datas = results.filter(data => {
        const regex = new RegExp(`^${text}`, 'gi')
        return data.title.match(regex) || data.title.match(regex)
    })


    console.log(datas);
    toHtml(datas);

}
const toHtml = datas => {
    if (datas.length > 0) {
        var html1 = ''
        for (let i = 0; i < datas.length; i++) {
            html1 += `<div class="post-preview">
              <a href="single.php?id=${datas[i]._id}">
                  <h2 class="post-title">
                    ${datas[i].title}
                  </h2>
                  <h3 class="post-subtitle">
                    ${datas[i].subtitle}
                  </h3>
                  </a>
                    <p class="post-meta">Ecrit par
                      <a href="profile.php?user=${datas[i].user}">
                        ${datas[i].user}
                      </a>
                      le ${datas[i].create_at}
                    </p>
          </div>
          <hr>`
        }
        let html = datas.map(data => {
            `<div class="post-preview">
              <a href="single.php?id=${data._id}">
                  <h2 class="post-title">
                    ${data.title}
                  </h2>
                  <h3 class="post-subtitle">
                    ${data.subtitle}
                  </h3>
                  </a>
                    <p class="post-meta">Ecrit par
                      <a href="profile.php?user=${data.user}">
                        ${data.user}
                      </a>
                      le ${data.create_at}
                    </p>
          </div>
          <hr>`
        }).join('');
        // console.log(html1);
        content.innerHTML = html1;
    }
}

search.addEventListener('input', () => getPost(search.value))
</script>