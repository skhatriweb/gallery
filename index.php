<?php require_once("includes/header.php"); ?>
<?php require_once("admin/includes/init.php"); ?>
<?php
$items_per_page=8;
$current_page=(int)$_GET['page'];
$total_items=count(Photo::find_all());

$paginate= new Paginate($current_page,$total_items,$items_per_page);
if(empty($current_page) || ($current_page >$paginate->total_pages())){
    redirect("index.php?page=1");
}
$sql= "SELECT * FROM photos LIMIT {$paginate->items_per_page} OFFSET {$paginate->offset()}";
$photos=Photo::find_this_query($sql);

?>

<div class="row">

    <div class="col-md-12">

                   <?php foreach($photos as $photo): ?>

                            <div class=" col-xs-12 col-md-3">
     <a  href="photo.php?id=<?php echo $photo->id; ?> "> <img class="thumbnail" height="33%" width="100%" src="<?php echo 'admin'.DS.$photo->imagePath(); ?> " alt="" class="img-rounded"></a>
                            </div>

                    <?php endforeach; ?>

    </div>

</div>
<div class="row">
    <ul class="pager">
        <?php
        if($paginate->total_pages()>1){

           if($paginate->has_next()){
               echo "<li class='pull-left'><a href='index.php?page={$paginate->next()}'>Next</a></li>";
           }

           for($i=1; $i <=$paginate->total_pages(); $i++){
              if($paginate->current_page == $i){

                  echo "<li  ><a class='active'' href='index.php?page={$i}'>{$i}</a></li>";
              }else{
                  echo "<li ><a  href='index.php?page={$i}'>{$i}</a></li>";

              }
           }


            if($paginate->has_previous()){
                echo "<li class='pull-right'><a href='index.php?page={$paginate->previous()}'>Previous</a></li>";
            }
        }
        ?>

    </ul>


</div>
<footer>
    <div class="row ">
        <div class="col-lg-8 col-md-offset-2">
            <p class="text-center">Copyright &copy; Your Website 2014</p>
        </div>
    </div>
    <!-- /.row -->
</footer>

