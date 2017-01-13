<?php

class Comment extends Db_object{

    public  $id;
    public  $photo_id;
    public  $author;
    public  $body;

    public static $db_table="comments";
    public static $db_table_fields=['id','photo_id','author','body'];
//how to create object from the input from form data
    public  function create_comment_object($photo_id,$author="Anonymous",$body=""){

        if(!empty($photo_id) && !empty($author) && !empty($body)){
            global $database;
            $comment= new Comment();
            $comment->photo_id=(int)$photo_id;
            $comment->author=$author;
            $comment->body="$body";
            $properties=$comment->getCleanAssArrOfObjPro();

            $sql="INSERT INTO ".static::$db_table."(".implode(",",array_keys($properties)).")";
            $sql.="VALUES ('".implode("','",array_values($properties))."')";
            if($database->query($sql)){
                $comment->id= $database->insertId();

                return true;

            }else{

                return false;
            }
        } else{

            return false;
        }

    }//create_comment_object

//how to convert that instance of object in to associative array so that we can use in sql query as key and values
    public  function convertObjIntoAssArr(){

        $assArrOfObjPro = array();
//taking value from array and checking if property is in class and than assign key and value to make array
        foreach(self::$db_table_fields as $db_table_field){
            if(property_exists($this,$db_table_field)){
                $assArrOfObjPro[$db_table_field] = $this->$db_table_field;
            }
        } return $assArrOfObjPro;
    }//convert_into_associative_array

    public function getCleanAssArrOfObjPro(){
        global $database;
        $cleanAssArrOfObjPro=array();

        foreach($this->convertObjIntoAssArr() as $key=>$value){

            $cleanAssArrOfObjPro[$key]=$database->realEscapeString($value);
        }
        return $cleanAssArrOfObjPro;
    }


    public static function  find_comments_by_photo_id($photo_id) {
        global $database;
        $sql = "SELECT * FROM " . self::$db_table . " WHERE photo_id = " . $database->realEscapeString($photo_id) . " ORDER BY photo_id ASC";

        return self::submit_query($sql);
    }//end of find_comments_by_photo_id method

    public static function find_comment_by_comment_id($id){
        global $database;
        $sql = "SELECT * FROM " . self::$db_table . " WHERE id = " . $database->realEscapeString($id) ." LIMIT 1";
        $the_result_array= self::submit_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) :false;
    }//end find_comment_by_comment_id method

    public static function find_all_comments(){
        global $database;
        $sql = "SELECT * FROM " . self::$db_table ;
        return self::submit_query($sql);
    }//end find_all_comments method


        public static function submit_query($sql){

         global $database;
        $result= $database->query($sql);
        $object_array= array();
        while($row=mysqli_fetch_array($result)){
            $object_array[] =  self::make_object($row);

        }

         return $object_array;
    }//end of find_comments_by_photo_id

    public static function make_object($row){
        $comment= new Comment();
        foreach($row as $key=>$value){
           if($comment->checkIfObjectHasAttribute($key)){
                $comment->$key= $value;
           }

        }
        return $comment;
    }//end of make_object

    public  function checkIfObjectHasAttribute($key){
        $listOfClassAttribute= get_object_vars($this);
        return array_key_exists($key,$listOfClassAttribute);
    }// end of checkIfObjectHasAttribute

    public function delete_comment(){
        global $database;
        $sql="DELETE FROM ".self::$db_table." WHERE id= ".$database->realEscapeString($this->id)." LIMIT 1";
        echo $sql;
        if($database->query($sql)){
            return mysqli_affected_rows($database->connection)==1 ? true:false;
        }
    }

}//end of class Comment
?>