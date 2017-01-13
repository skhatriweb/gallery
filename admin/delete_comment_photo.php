<?php
require_once("includes/init.php");

if(!$session->is_signed_in()){
    redirect("login.php");
}

$id= $_GET['id'];
if(empty($id)){
    redirect ("photo_comments.php");
}

$comment= Comment::find_by_id($id);

if($comment){
    if($comment->delete_by_id()){
        $session->message("Comment with id <strong>{$comment->id}</strong> has been deleted");
       redirect("photo_comments.php?id={$comment->photo_id}");
    }
}else{
    redirect("photo_comments.php?id={$comment->photo_id}");

}


?>