<?php
require_once("init.php");
$user= new User;
if(isset($_POST['image_name']) && isset($_POST['user_id'])){


    echo $user->ajax_save_user_image($_POST['user_id'],$_POST['image_name']);
}

if(isset($_POST['photo_id'])){

   echo User::modal_sidebar_image($_POST['photo_id']);
}




?>


