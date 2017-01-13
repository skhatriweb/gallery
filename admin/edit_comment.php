<?php include("includes/header.php"); ?>

<!-- Navigation -->
<?php  include "includes/topnav.php"; ?>
<!--make sure user authenticated-->
<?php if(!$session->is_signed_in()){  redirect("login.php");}?>
<?php

if(empty($_GET['id'])){
    redirect("comments.php");
}else{
    $comment=Comment::find_by_id($_GET['id']);
    if(isset($_POST['update'])){

        if($comment){


            $comment->author= $_POST['author'];
            $comment->body= $_POST['body'];

            if($comment->update_by_id()){
              $session->message("Comment id <strong>{$comment->id}</strong> has been updated");
             redirect("comments.php");
              //redirect("edit_comment.php?id= {$comment->id}");
          }


        }
    }else{


    }
}

?>



<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    COMMENTS
                    <small>Edit Comment</small>
                </h1>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text"id="author" name="author" class="form-control" value="<?php echo $comment->author; ?>">
                        </div>


                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" name="body" cols="30" rows="10" ><?php echo $comment->body;?></textarea>
                        </div>

                        <div>
                            <input type="submit" name="update" value="Update">
                        </div>
                    </div><!--end of col-md-12-->

                </form>


            </div>
        </div>
        <!-- /.row -->

    </div>

</div>
<!-- /#page-wrapper -->

