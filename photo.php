<?php
require_once("admin/includes/init.php");
$photo;
$message="";
/*
if(isset($session)){
    $user= User::find_by_id($session->user_id);
}
*/

if(empty($_GET['id'])){
   redirect("index.php");
}else{
    $photo= Photo::find_by_id($_GET['id']);
    $comments = Comment::find_by_photo_id($_GET['id']);
}



if(isset($_POST['submit'])){

    $author=trim($_POST['author']);
    $body=trim($_POST['body']);
    if(!empty ($author) && !empty($body)){
        $comment= new Comment();
        $comment->author= $author;
        $comment->body= $body;
        $comment->photo_id=$photo->id;
        if($comment->create()){
            redirect("photo.php?id={$photo->id}");
        }else{
            $message="Comment could not be saved";
        }

    }
}else{
    $author="";
    $body="";
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Photo</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
   <?php include("includes/navigation.php");?>

    <!--end of navigation-->


    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8 col-md-offset-2">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo $photo->title; ?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">Sanjay Khatri</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p>

                <hr>

                <!-- Preview Image
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">

                -->
                <img class="img-responsive" width="100%" src="<?php echo "admin/images/".$photo->filename; ?>" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?php echo $photo->caption;?></p>
                <p><?php echo $photo->description; ?></p>

                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="POST">

                        <div class="form-group">
                            <lable for="author">Author</lable>
                            <input type="text" name="author" class="form-control">

                        </div>
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div>
                    <?php echo $message; ?>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->

                <?php  foreach($comments as $comment): ?>
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>

                        <div class="media-body">
                            <h4 class="media-heading">Author
                                <small><?php echo $comment->author; ?></small>
                            </h4>
                            <?php echo $comment->body;?>
                        </div>
                    </div>


                <?php endforeach ;?>


                <!-- Comment -->


            </div>

            <!-- Blog Sidebar Widgets Column -->


        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row text-center">
                <div class="col-lg-8 col-md-offset-2">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
