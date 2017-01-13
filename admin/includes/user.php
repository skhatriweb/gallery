<?php

class User extends Db_object{

    public $id;
    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $filename;
    public $upload_directory ="images";
    public $image_placeholder="http://placehold.it/400x400&text=image";
    protected static $db_table="users";
    protected static $db_table_fields= array('username','password','firstname','lastname','filename');
    public $errors = array();
    public $tmp_path;


    public static function verify_user($username,$password){
       global $database;

       $sql="SELECT * FROM ".self::$db_table." WHERE ";
       $sql.=" username ='".$database->realEscapeString($username)."'";
       $sql.=" AND password ='".$database->realEscapeString($password)."' LIMIT 1";

       $verifiedUser = self::find_this_query($sql);
       return !empty($verifiedUser) ? array_shift($verifiedUser) :false;


    }//end of verify_user method
    public function user_image_photo(){

        return empty($this->filename) ? $this->image_placeholder: $this->upload_directory.DS.$this->filename;
    }//end of user_image_photo method

    public function ajax_save_user_image($user_id,$image_name){
        global $database;
        $this->id= $database->realEscapeString($user_id);
        $this->filename = $database->realEscapeString($image_name);
        $sql="UPDATE ".self::$db_table." SET filename= '{$this->filename}'  WHERE id = '{$this->id}'";
        if($database->query($sql)){
            return $this->user_image_photo();
        }

    }//end of ajax_save_user_image

    public static function modal_sidebar_image($id){
        if($id) {
            $photo = Photo::find_by_id($id);
            $output = "<a href='#'><img class='modal_thumbnails img-responsive' src='{$photo->imagePath()}' ></a>";
            $output .= "<p><?php  $photo->title; ?></p>";
            $output .= "<p>{$photo->filename}</p>";
            $output .= "<p>{$photo->type}</p>";
            $output .= "<p>{$photo->size}</p>";
            return $output;
        }
    }



}//end of User class


?>