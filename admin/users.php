<?php include("includes/header.php"); ?>

        <!-- Navigation -->
<?php  include "includes/topnav.php"; ?>
<!--make sure user authenticated-->
<?php if(!$session->is_signed_in()){  redirect("login.php");}?>
<?php   $users=User::find_all(); ?>

        <div id="page-wrapper">

           <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">


                        <h1 class="page-header">
                            Users

                        </h1>
                        <p class="bg-success"><?php echo $session->message();?></p>


                        <a href="add_user.php" class="btn btn-primary">Add User</a>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>

                                        <th>Id</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <!--best way to avoid echo -->
                                   <?php foreach ($users as $user): ?>

                                       <tr>
                                           <td><?php echo $user->id ?></td>
                                          <td><img src="<?php echo $user->user_image_photo() ?>"  class="user_image" alt=""></td>
                                           <td><?php echo $user->username; ?>
                                               <div id="pictures_link">
                                                   <a class="delete_link" href="delete_user.php?id=<?php echo $user->id;  ?>">Delete |</a>
                                                   <a href="edit_user.php?id=<?php echo $user->id; ?>">Edit |</a>
                                                   <a href="#">View</a>
                                               </div>
                                           </td>
                                           <td><?php echo $user->firstname;?></td>
                                           <td><?php echo $user->lastname;?></td>
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