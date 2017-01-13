<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){ redirect("login.php");} ?>
        <!-- Navigation -->
 <?php include "includes/topnav.php";  ?>

<?php

if(isset($_FILES['file'])){

    $file = $_FILES['file'];
    $photo= new Photo;
    $photo->title=$_POST['title'];
    $photo->description=$_POST['description'];
    $photo->set_file($file);
    if($photo->save_image()){
       if($photo->create()){

           $session->message("The photo <strong>{$photo->title}</strong> has been uploaded");
         //  $message= "File saved successfully";
           redirect("photos.php?page=1");
       }
    }else{
       // $message=join("<br>",$photo->errors);
        $errorsToThrow= join("<br>",$photo->errors);
        $session->message($errorsToThrow);
        redirect("photos.php?page=1");
    }


}
?>

        <div id="page-wrapper">

           <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Uploads
                            <small>photos</small>
                        </h1>
                        <div class="row">

                            <div class="container col-md-6 col-md-offset-3">

                                <form class="form" action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" name="description" class="form-control">
                                    </div>
                                    <div class="form-group">

                                        <!--<label for="file">File to upload</label>-->
                                        <input type="file" name="file" class="hidden">

                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <input type="submit" name="submit" class="btn btn-default">

                                    </div>
                                    -->

                                 </form>
                             </div>
                        </div>
                        <div class="row col-md-12">
                            <form class="dropzone" action="upload.php">

                            </form>

                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>