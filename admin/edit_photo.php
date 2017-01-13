<?php include("includes/header.php"); ?>

        <!-- Navigation -->
<?php  include "includes/topnav.php"; ?>
<!--make sure user authenticated-->
<?php if(!$session->is_signed_in()){  redirect("login.php");}?>
<?php

if(empty($_GET['id'])){
    redirect("photos.php");
}else{
    $photo=Photo::find_by_id($_GET['id']);
    if(isset($_POST['update'])){

        if($photo){
            $photo->title= $_POST['title'];
            $photo->caption= $_POST['caption'];
            $photo->alternate_text= $_POST['alternate_text'];
            $photo->description= $_POST['description'];

            $file =$_FILES['uploaded_file'];

            if($file['error'] != 0){
                $photo->update();
                $session->message("Photo with title <strong>{$photo->title}</strong> updated");
                redirect("edit_photo.php?id={$photo->id}");

            } else {
                $old_target_file=$photo->imagePath();
                $photo->set_file($file);
                if($photo->save_image()){
                    $photo->update();
                    unlink($old_target_file);
                    $session->message("Photo with title <strong>{$photo->title}</strong> updated");
                    redirect("edit_photo.php?id={$photo->id}");
                 }else{
                    $errorToThrow=join("<br>",$photo->errors);
                    $session->message($errorToThrow);
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
                            PHOTOS

                        </h1>
                        <p class="bg-success"><?php echo $session->message();?></p>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="col-md-8">

                                <div class="form-group">
                                    <input type="text" name="title" class="form-control" value="<?php echo $photo->title ;?>">
                                </div>
                                <div>
                               <p><a href ="#"><img class="admin_photo_thumbnail" src="<?php echo $photo->imagePath(); ?>" alt=""></a></p>
                                <p><input type="file" name="uploaded_file"</p>
                                </div>

                                <div class="form-group">
                                    <lable for="caption">Caption</lable>
                                    <input type="text" name="caption" class="form-control" value="<?php echo $photo->caption ;?>">
                                </div>
                                <div class="form-group">
                                    <lable for="alternate_text">Alternate text</lable>
                                    <input type="text" name="alternate_text" class="form-control" value="<?php echo $photo->alternate_text ;?>">
                                </div>
                                <div class="form-group">
                                    <lable for="description">Description</lable>
                                    <textarea class="form-control" name="description" cols="30" rows="10" ><?php echo $photo->description;?></textarea>
                                </div>
                            </div><!--end of col-md-8-->
                            <div class="col-md-4">
                                <div  class="photo-info-box">
                                    <div class="info-box-header">
                                        <h4>Save <span id="toggle" class="glyphicon glyphicon-menu-up pull-right"></span></h4>
                                    </div>
                                    <div class="inside">
                                        <div class="box-inner">
                                            <p class="text">
                                                <span class="glyphicon glyphicon-calendar"></span> Uploaded on: April 22, 2030 @ 5:26
                                            </p>
                                            <p class="text ">
                                                Photo Id: <span class="data photo_id_box"><?php echo $photo->id ;?></span>
                                            </p>
                                            <p class="text">
                                                Filename: <span class="data"><?php echo $photo->filename ;?></span>
                                            </p>
                                            <p class="text">
                                                File Type: <span class="data"><?php echo $photo->type ;?></span>
                                            </p>
                                            <p class="text">
                                                File Size: <span class="data"><?php echo $photo->size ;?></span>
                                            </p>
                                        </div>
                                        <div class="info-box-footer clearfix">
                                            <div class="info-box-delete pull-left">
                                                <a  href="delete_photo.php?id=<?php echo $photo->id; ?>" class="btn btn-danger btn-lg ">Delete</a>
                                            </div>
                                            <div class="info-box-update pull-right ">
                                                <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg ">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!--end of col-md-4-->
                        </form>


                    </div>
                </div>
                <!-- /.row -->

            </div>

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>