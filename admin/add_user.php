<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){ redirect("login.php");} ?>
        <!-- Navigation -->
 <?php include "includes/topnav.php";  ?>

<?php

if(isset($_POST['create'])){

    $file = $_FILES['uploaded_file'];

    $user= new User();

    $user->username=$_POST['username'];
    $user->firstname=$_POST['firstname'];
    $user->lastname=$_POST['lastname'];
    $user->password=$_POST['password'];

    if($file['error'] != 0){
       $user->create();
        $session->message("User <strong>{$user->username}</strong> created  successfully");
        redirect("users.php");
       // $message="Record saved successfully";
    }else{

        if($user->set_file($file)){
            if($user->save_image()){
                if($user->create()){
                    // $message="Record saved successfully";
                    $session->message("User <strong>{$user->username}</strong> created  successfully");
                    redirect("users.php");
                }
            }else{
                $errorToThrow=join("<br>",$user->errors);
                $session->message($errorToThrow);
                redirect("users.php");
                //$message=join("<br>",$user->errors);
            }

        }else{
            $errorToThrow=join("<br>",$user->errors);
            $session->message($errorToThrow);
            redirect("users.php");
            //$message=join("<br>",$user->errors);
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
                           USER
                            <small>Add user</small>
                        </h1>
                        <div class="container col-md-6 col-md-offset-3">

                            <form class="form" action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="uploaded_file">User photo</label>
                                    <input type="file" name="uploaded_file" >
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="firstname">Firstname</label>
                                    <input type="text" name="firstname" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Lastname</label>
                                    <input type="text" name="lastname" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="submit" name="create" class="btn btn-primary pull-right">
                                </div>
                             </form>
                         </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>