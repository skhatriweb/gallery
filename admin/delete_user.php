<?php

require_once("includes/init.php");

if(!$session->is_signed_in()){
    redirect("login.php");
}

if(empty($_GET['id'])){
    redirect("users.php");
}
$user=User::find_by_id($_GET['id']);

if($user){

    $user->delete_obj();
    $session->message("The user <strong> {$user->username }</strong> has been deleted");
    redirect("users.php");



}else{
    $session->message("Ops ! something went wrong . The user not found");
    redirect("users.php");
}

?>