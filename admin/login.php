<?php

require_once("includes/header.php");

if($session->is_signed_in()){

    redirect("index.php");
}


if(isset($_POST['submit'])){

    $username=trim($_POST['username']);
    $password=trim($_POST['password']);




    $verifiedUser= User::verify_user($username,$password);


 if($verifiedUser){

       $test= $session->login($verifiedUser);

       redirect('index.php');
    }else{

        $the_message= "Authentication fail for provided credentials";
    }





}else{
    $username="";
    $password="";
    $the_message="";

}


?>

<div class="col-md-4 col-md-offset-3">

<h4 class="bg-danger"><?php  echo $the_message; ?></h4>

    <form id="login_form" action="" method="POST">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="<?php  echo htmlentities($username)?>" >

        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" value="<?php  echo htmlentities($password)?>">

        </div>


        <div class="form-group">
            <input type="submit" name="submit" value="submit" class="btn btn-primary">

        </div>


    </form>


</div>
