<?php

require_once("includes/init.php");

if(!$session->is_signed_in()){
    redirect("login.php");
}

if(empty($_GET['id'])){
    redirect("photos.php");
}
$photo=Photo::find_by_id($_GET['id']);

if($photo){

    $photo->delete_obj();
    $session->message("The photo with id <strong>{$photo->id}</strong> has been deleted");
    redirect("photos.php?page=1");


}else{

    redirect("photos.php");
}

?>