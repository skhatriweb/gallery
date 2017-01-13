<?php include("includes/header.php"); ?>

        <!-- Navigation -->
<?php  include "includes/topnav.php"; ?>
<!--make sure user authenticated-->
<?php if(!$session->is_signed_in()){  redirect("login.php");}?>
<?php
$items_per_page=10;
$current_page=(int)$_GET['page'];
$total_items=count(Photo::find_all());

$paginate= new Paginate($current_page,$total_items,$items_per_page);


if(empty($current_page) || ($current_page >$paginate->total_pages())){

   redirect("photos.php?page=1");
}
$sql= "SELECT * FROM photos LIMIT {$paginate->items_per_page} OFFSET {$paginate->offset()}";
$photos=Photo::find_this_query($sql);

?>

        <div id="page-wrapper">

           <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Photos

                        </h1>
                        <div class="bg-success"><?php echo $session->message();?></div>

                        <div class="col-md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Comments </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!--best way to avoid echo -->
                                   <?php foreach ($photos as $photo): ?>

                                       <tr>
                                            <td><img class="admin_photo_thumbnail" src="<?php echo $photo->imagePath(); ?>" alt="">
                                                <div id="pictures_link">
                                                    <a class="delete_link" href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete |</a>
                                                    <a href="edit_photo.php?id=<?php echo $photo->id; ?>">Edit |</a>
                                                    <a href="../photo.php?id=<?php echo $photo->id; ?>">View</a>
                                                </div>
                                           </td>
                                           <td><?php echo $photo->id ?></td>
                                           <td><?php echo $photo->title; ?></td>
                                           <td><?php echo $photo->type;?></td>
                                           <td><?php echo $photo->size; ?></td>
                                           <td><a href="photo_comments.php?id=<?php echo $photo->id;?>">
                                               <?php
                                               $comments=Comment::find_by_photo_id($photo->id);
                                               echo count($comments);

                                               ?>
                                               </a>
                                           </td>
                                       </tr>

                                    <?php endforeach ;?>


                                </tbody>
                            </table><!--end of table-->

                        </div>


                    </div>
                </div>
                <!-- /.row -->
               <hr />
               <div class="row">
                   <ul class="pager">
                       <?php
                       if($paginate->total_pages()>1){

                           if($paginate->has_next()){
                               echo "<li class='pull-left'><a href='photos.php?page={$paginate->next()}'>Next</a></li>";
                           }

                           for($i=1; $i <=$paginate->total_pages(); $i++){
                               if($paginate->current_page == $i){

                                   echo "<li><a class='active'' href='photos.php?page={$i}'>{$i}</a></li>";
                               }else{
                                   echo "<li><a href='photos.php?page={$i}'>{$i}</a></li>";

                               }
                           }


                           if($paginate->has_previous()){
                               echo "<li class='pull-right'><a href='photos.php?page={$paginate->previous()}'>Previous</a></li>";
                           }
                       }
                       ?>

                   </ul>


               </div>

            </div>

        </div>
        <!-- /#page-wrapper -->

    <?php include("includes/footer.php");