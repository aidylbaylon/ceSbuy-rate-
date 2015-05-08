    <?php

    require 'core/init.php';

    $general->logged_out_protect();

      $username = $user['username']; // using the $user variable defined in init.php and getting the username.



      ?>

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
              <!-- Put some categories -->
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
               <form class="form-inline pull-right" role="form" method="post">
                <div class="form-group">               
                  <input type="search" class="form-control" placeholder="Search for over 10,000 products">
                </div> 

                <button type="button" class="btn btn-default" name = "search" onclick="window.location.href='search.php'">Search Products</button>
                <button class="btn btn-warning " data-toggle="modal" data-target="" onclick="window.location.href='add_post_2.php'">
                  <span class="glyphicon glyphicon-hand-up"></span> Sell your products!
                </button>


              </form>
            </ul> 
            <div class="panel-body">
             <div class="row carousel-holder">

              <div class="col-md-12">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="item active">
                      <img class="slide-image" src="img/slide/slide0.jpg">
                    </div>
                    <div class="item">
                      <img class="slide-image" src="img/slide/slide1.jpg">
                    </div>
                    <div class="item">
                      <img class="slide-image" src="img/slide/slide2.jpg">
                    </div>
                  </div>
                  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                  </a>
                  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </a>
                </div>
              </div>

            </div> 
          </div>
          <div class="row">

            <?php 
            foreach ($users->get_all_posts() as $product) {

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
                <?php 
                $article = null;
                
                if (isset($product['post_id'])) {
                  $id = (int)$product['post_id'];

                  $article = $db->query("SELECT * FROM posts WHERE post_id = $id")->fetch(PDO::FETCH_ASSOC);
                  $article2 = $db->query("SELECT AVG(ratings) AS rate FROM `article_rating` WHERE article = $id")->fetch(PDO::FETCH_ASSOC);
                  

                } 
                ?>
                <?php if($article): ?>
                <div class="rate_widget">
                  <p class="pull-right"><?php echo round($article2['rate'],1); ?> reviews</p>
                  <p>
                    <?php foreach(range(1,5) as $rating): ?>
                    <a href="rate.php?article=<?php echo $article['post_id']; ?>&rating=<?php echo $rating; ?>"><span class="glyphicon glyphicon-star-empty"></span></a>
        <!-- 
                    
                    <span class="glyphicon glyphicon-star-empty"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                  -->            
                <?php endforeach;?>

              </p>  

              <!--  <img src="img/demo/star_empty.png"> -->
                 <!--  <div class="star_1 ratings_stars"></div>
                 <div class="star_2 ratings_stars"></div>
                <div class="star_3 ratings_stars"></div>
                 <div class="star_4 ratings_stars"></div>
                <div class="star_5 ratings_stars"></div>
                <div class="total_votes">vote data</div> -->
              </div>

            <?php endif;?>
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
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Step 1 of 2: Fill Up the Insert Ad Form</h4>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Add Details</h3>
            </div>
            <div class="panel-body">
             <form class="form-horizontal" role="form">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Category</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Category">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Region</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Region">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Province</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Province">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">City</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="City">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Ad title</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Ad title">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Add Description</label>
                <div class="col-sm-10">
                  <textarea class="form-control" rows="3"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Price">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Image</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Image">
                </div>
              </div>

            </forn>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


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