    <?php
    
    include'core/init.php';

    $general->logged_out_protect();
     
    $username = $user['username']; // using the $user variable defined in init.php and getting the username.

    $p_data=array();

    $user_id = $users->fetch_info('id', 'username', $username); // Getting the user's id from the username in the Url.

    $post_id = $_GET['post_id'];
    
    $profile_data = $users->userdata($user_id);

    $p_data = $users->post_data($post_id);

    $comments = $users->get_comments($p_data['post_id']);
     
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

    <script src="js/jquery.min.js"></script>
    
    <script type="text/javascript">
     
    </script>


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
             <form class="form-inline pull-right" role="form">
                <div class="form-group">               
                  <input type="search" class="form-control" placeholder="Search for over 10,000 products">
                </div>               
                <button type="submit" class="btn btn-default">Search</button>
                <button class="btn btn-warning " data-toggle="modal" data-target="" onclick="window.location.href='add_post_2.php'">
              <span class="glyphicon glyphicon-hand-up"></span> Sell your products!
            </button>

              </form>
          </ul> 
          <div class="panel-body">
            
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-8"><!-- dri ibutang ang code sa setting plss h1 ang code lang. -->
                    

                <?php

                if(isset($_POST['delete']))
                {
                  $users->delete_post($p_data['post_id']);
                  header('Location: view_post.php?success');
                  exit();
                }

                if (isset($_POST['comment'])) 
                {
                  // echo '<h3>You added a comment to this post.</h3>'; 
                  $description = htmlentities(trim($_POST['description']));

                  $filter->strings = array('damn','atay','pisti', 'bullshit', 'fuck','shit');

                  $filter->text = $_POST['description'];

                  $filter->keep_first_last = false;

                  $filter->replace_matches_inside_words = false;

                  $description = $filter->filter();

                  $users->add_comment($user_id,$p_data['post_id'],$description);

                  header('Location: view_post.php?post_id='.$post_id);
                  exit();

                }

                ?>
                
                
                <?php 


                  if (isset($_GET['success']) && empty($_GET['success'])) {
                  echo '<h3>Your product has been deleted!  </h3>';    
                  }

                  else
                  {
                    echo '<form method="POST" action="">';
                    echo '<a href="your_posts.php?username='.$user['username'].'"></a>';
                    $image = $p_data['image_location'];
                    echo "<img src='$image'>".'<br />';
                    echo 'Name: '.$p_data['name'].'<br />';
                    echo 'Price: '.$p_data['price'].'<br />';
                    echo 'Category: '.$p_data['category'].'<br />';
                    echo 'Description: '.$p_data['description'].'<br />';
                    echo '<form/>';
                  
                ?> 

                <hr />

                <h4>Comments</h4>

                          

                <?php 

                    if(empty($comments))
                    {
                      echo 'There are no comments in this post...';
                    }

                    else
                    {
                      foreach ($comments as $c) {
                      echo "<b>".$username.' </b>said at '.date('m/d/Y H:i A', strtotime($c['time_added'])).'<br />&nbsp;';
                      echo $c['comment'].'<br />';
                      echo '<hr />';
                    }
                    }

                 ?> 

                <br />

                <hr />
                <!-- <p><strong><?php echo $row['username']; ?></strong> said at <?php echo date('m/d/Y H:i A', strtotime($row['date_added'])) ?><br /></p> -->

                <form action="" method="post" id="form" enctype="multipart/form-data">
          
                      <div class="form-group">
                        <div class="controls">
                               <label for="exampleInputPassword1">Add Comment</label>
                         </div>
                        <textarea class="form-control"  name="description" placeholder="Please use the English language."></textarea>
                        <!-- <input name="description" type="text" class="form-control" id="exampleInputPassword1" placeholder="Description"> -->
                      </div>
                      <button type="submit" name = "comment" id="submit" class="btn btn-primary" >Add Comment</button>
                      <button type="reset" name = "cancel" class="btn btn-default">Cancel</button>
                </form>

              <?php } ?>

              </div>
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
