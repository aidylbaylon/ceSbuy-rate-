<?php

require 'core/init.php';

$general->logged_out_protect();

$username = $user['username']; // using the $user variable defined in init.php and getting the username.

?>

because fuck you that's why <?php echo $_GET["category"] ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Welcome to Cesbuy </title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <!-- Add custom CSS here -->
  <link href="css/shop-homepage.css" rel="stylesheet">

</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">

      <!--<h1>Hello <?php echo $username, '!'; ?></h1>-->

      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <a href="#" class="navbar-brand">Hello <?php echo $username, '!'; ?></a>

      </div>



      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-ex1-collapse">



        <form class="form-inline pull-right" role="form">
          <div class="form-group">
            <ul class="nav navbar-nav">
              <?php include 'includes/menu.php'; ?>

            </ul>
          </div>
          <div class="btn-group">

            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              <span class="glyphicon glyphicon-cog"></span><span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="profile.php?username=<?php echo $user['username'];?>">Profile</a></li>
              <li><a href="settings.php">Account Setting</a></li>
              <li><a href="#">Privacy Setting</a></li>
              <li class="divider"></li>
              <li><a href="logout.php">Log out</a></li>
            </ul>
          </div>
        </form>

      </div><!-- /.navbar-collapse -->


    </div><!-- /.container -->
  </nav>

  <div class="container">

    <div class="row">

      <div class="col-md-3">
        <p class="lead"><img src="img/logo1.png" width="290x" height="80px"></p>

        <div class="list-group">
          <p>Categories</p>
            <a href="post_by_category.php?category=Clothings" class="list-group-item">Clothings</a>
            <a href="post_by_category.php?category=Phones" class="list-group-item">Phones</a>
            <a href="post_by_category.php?category=Gadgets" class="list-group-item">Gadgets</a>
            <a href="post_by_category.php?category=Electronics" class="list-group-item">Electronics</a>
            <a href="post_by_category.php?category=Furnitures" class="list-group-item">Furnitures</a>
            <a href="post_by_category.php?category=Others" class="list-group-item">Others</a>
        </div>



      </div>

      <div class="col-md-9">

        <div class="col-md-15 col-md-offset-1">

          <ul class="nav nav-tabs">
            <form class="form-inline pull-right" role="form" method="post"  action="<?php echo $_SERVER['PHP_SELF'];?>">
              <div class="form-group">               

              </div>  


              <button type="button" class="btn btn-default" name = "search" onclick="window.location.href='/cesbuy_rosie/search.php'">Search Products</button>
              <button class="btn btn-warning " data-toggle="modal" data-target="#" onclick="window.location.href='add_post_2.php'">
                <span class="glyphicon glyphicon-hand-up"></span> Sell your products!
              </button>


            </form>
          </ul> 
          <div class="panel-body">
            <div class="row carousel-holder">

              <div class="col-md-12">

              </div>

            </div> 
          </div>
          <div class="row">

            <?php 

              $stuff = $users->post_by_category($_GET["category"]);
              echo "<pre>";
                // print_r($stuff);
              echo "</pre>";
            ?>

            <?php 
            foreach ($stuff as $product) {
            
            $image = $product['image_location'];
            $price = $product['price'];
            $name = $product['name'];
            $category = $product['category'];
            $description = $product['description'];
          ?>

            <div class="col-sm-4 col-lg-4 col-md-4">
              <div class="thumbnail">
                
               <?php echo '<a href="view_post.php?post_id='.$product['post_id'].'"><img src='.$image.' width="400px" height="400px" >'; ?>
                <div class="caption">
                  <h4 class="pull-right">P<?php echo $price;?></h4>
                  <h4><a href="#"><?php echo $name;?></a></h4>
                  <p><?php echo $description; ?><br /><h4><?php echo $category;?></h4></a></p>
                </div>
                <div class="ratings">
                  <p class="pull-right">0 reviews</p>
                  <p>
                    <span class="glyphicon glyphicon-star-empty"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                  </p>
                </div>
              </div>
            </div>
            <?php 
          }
          ?>


          </div>
        </div>
      </div>
    </div>

  </div>

</div>



</div><!-- /.container -->

<div class="container">

  <hr>

  <footer>
    <div class="row">
      <div class="col-lg-12">
        <p>Copyright @ CesBuy 2014</p>
      </div>
    </div>
  </footer>

</div><!-- /.container -->

<!-- JavaScript -->
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.js"></script>

</body>
</html>