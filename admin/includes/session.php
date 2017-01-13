<?php

class Session{

    public  $user_id;

    private $signed_in  = false;

    public $count;

    public $message;


    function __construct(){

        session_start();
        $this->check_the_login();
        $this->total_views();
        $this->check_message();
    }//end of __construct method

    public function check_message(){

        if(isset($_SESSION['message'])){
            $this->message= $_SESSION['message'];
            unset($_SESSION['message']);
        }else{
            $this->message="";
        }

    }//end of check_message method

    public function message($msg=""){
        if(!empty($msg)){
            $_SESSION['message']=$msg;
        }else{
            return $this->message;
        }
    }//end of message method

    public function login($verifiedUser){
        if($verifiedUser){

            $this->user_id = $verifiedUser->id;
            $_SESSION['user_id'] = $verifiedUser->id;
            $this->signed_in = true;


        }

    }//end of login method
    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in =false;


    }
    public function is_signed_in(){
            return $this->signed_in;
    }//end of is_signed_in
    private function check_the_login(){
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in= true;
        }else{
            unset($this->user_id);
            $this->signed_in=false;
        }
    }//end of check_the_login

    public function total_views(){
        if(isset($_SESSION['count'])){
          return $this->count= $_SESSION['count']++;

        }else{
            return $_SESSION['count']=1;
        }
    }//end of total_views



}//end of session class

$session = new Session();


?>