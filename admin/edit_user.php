<?php include("includes/header.php"); ?>
<?php include("includes/init.php"); ?>

        <!-- Navigation -->
<?php  include "includes/topnav.php"; ?>
<?php include "edit_user_modal.php"; ?>
<!--make sure user authenticated-->
<?php if(!$session->is_signed_in()){  redirect("login.php");}?>
<?php

if(empty($_GET['id'])){
    redirect("users.php");
}else{
    $user=User::find_by_id($_GET['id']);
    if(isset($_POST['update'])){

        if($user){
            $user->username= $_POST['username'];
            $user->firstname= $_POST['firstname'];
            $user->lastname= $_POST['lastname'];
            $user->password= $_POST['password'];

            $file =$_FILES['uploaded_file'];

            if($file['error'] != 0){
                $user->update();
               // redirect("edit_user.php?id={$user->id}");
                $session->message("The user <strong>{$user->username}</strong> has been updated");
                redirect("users.php");

            } else {
                $old_target_file=$user->upload_directory.DS.$user->filename;
                $user->set_file($file);
                if($user->save_image()){
                    $user->update();
                   if($old_target_file){
                       unlink($old_target_file);
                   }
                   // redirect("edit_user.php?id={$user->id}");
                    $session->message("The user <strong>{$user->username}</strong> has been updated");
                    redirect("users.php");
                 }else{
                    $errorsToThrow=join("<br>",$user->errors);
                    $session->message($errorsToThrow);
                    redirect("users.php");
                }
            }

        }
    }
}

?>



        <div id="page-wrapper">

           <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            USERS
                            <small>Edit user</small>
                        </h1>

                        <form action="" method="POST" enctype="multipart/form-data">

                            <div class="col-md-4">

                              <p><a href ="#" data-toggle="modal" data-target="#photo-modal"><img class="img-responsive" id="user_image_change" src="<?php echo $user->user_image_photo(); ?>" alt=""></a></p>
                              <p><input type="file" name="uploaded_file"</p>

                            </div><!--end of col-md-4-->

                            <div class="col-md-8">

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $user->username ;?>">
                                </div>

                                <div class="form-group">
                                    <lable for="firstname">Firstname</lable>
                                    <input type="text" name="firstname" class="form-control" value="<?php echo $user->firstname ;?>">
                                </div>
                                <div class="form-group">
                                    <lable for="lastname">Lastname</lable>
                                    <input type="text" name="lastname" class="form-control" value="<?php echo $user->lastname ;?>">
                                </div>
                                <div class="form-group">
                                    <lable for="password">Password</lable>
                                    <input type="password" name="password" class="form-control" value="<?php echo $user->password; ?>">
                                </div>

                                <div class="info-box-footer clearfix">
                                    <div class="info-box-delete pull-left">
                                        <a id="user-id" href="delete_user.php?id=<?php echo $user->id; ?>" class="btn btn-danger btn-lg ">Delete</a>
                                    </div>
                                    <div class="info-box-update pull-right ">
                                        <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg ">
                                    </div>
                                </div>

                            </div><!--end of col-md-8-->

                        </form>


                    </div>
                </div>
                <!-- /.row -->

            </div>

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>