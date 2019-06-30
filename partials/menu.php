<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img class="img-fluid" width="100" height="100"
                src="asset/galsen_medium.png" alt="Galsen Medium"> </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"> </i> Home <i class="fas fa-home"></i></a>
                </li>
                <?php
            if (isset($_SESSION['username'])){
                echo '
                <li class="nav-item">
                  <a class="nav-link" href="chat.php">Chat Room </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?task=logout">Logout</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="stats.php">Statistique <i class="fab fa-bar-chart" aria-hidden="true"></i></a>
                </li>
                ' ; 
            }
        ?>
            </ul>
        </div>
    </div>
</nav>