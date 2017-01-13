<?php include("includes/header.php"); ?>

<!-- Navigation -->
<?php  include "includes/topnav.php"; ?>
<!--make sure user authenticated-->
<?php if(!$session->is_signed_in()){  redirect("login.php");}?>
<?php
if(empty($_GET['id'])){
    redirect("photos.php");
}
$comments=Comment::find_by_photo_id($_GET['id']);
$photo=Photo::find_by_id($_GET['id']);
?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    PHOTO COMMENTS

                </h1>
                <p class="bg-success"><?php echo $session->message();?></p>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Photo</th>

                            <th>Comment Id</th>
                            <th>Author</th>
                            <th>Body</th>
                        </tr>
                        </thead>
                        <tbody>

                        <!--best way to avoid echo -->
                        <?php foreach ($comments as $comment): ?>

                            <tr>
                                <td><img class="admin_photo_thumbnail" src="<?php echo $photo->imagePath(); ?>" alt="">

                                </td>

                                <td><?php echo $comment->id; ?></td>
                                <td><?php echo $comment->author;?>
                                    <div>
                                      <a href="delete_comment_photo.php?id=<?php echo $comment->id; ?>">Delete</a>
                                    </div>


                                </td>
                                <td><?php echo $comment->body;?></td>
                            </tr>

                        <?php endforeach ;?>


                        </tbody>
                    </table><!--end of table-->

                </div>


            </div>
        </div>
        <!-- /.row -->

    </div>

</div>
<!-- /#page-wrapper -->



