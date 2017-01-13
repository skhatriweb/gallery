<?php include("includes/header.php"); ?>

<!-- Navigation -->
<?php  include "includes/topnav.php"; ?>
<!--make sure user authenticated-->
<?php if(!$session->is_signed_in()){  redirect("login.php");}?>
<?php
$comments= Comment::find_all();

?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
               Comments

                </h1>
                <p class="bg-success"><?php echo $session->message();?></p>

                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                        <tr>

                            <th>Id</th>
                            <th>Author</th>
                            <th>Body</th>


                        </tr>
                        </thead>
                        <tbody>

                        <!--best way to avoid echo -->
                        <?php foreach ($comments as $comment): ?>

                            <tr>
                                <td><?php echo $comment->id ?></td>

                                <td><?php echo $comment->author; ?>
                                    <div id="pictures_link">
                                        <a class="delete_link" href="delete_comment.php?id=<?php echo $comment->id;  ?>">Delete</a>
                                        <a href="edit_comment.php?id=<?php echo $comment->id;  ?>">Edit</a>

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

<?php include("includes/footer.php");