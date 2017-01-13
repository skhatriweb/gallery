<?php

class Comment {

    public $id;
    public $photo_id;
    public $author;
    public $body;

    public static $db_table_name="comments";
    public static $db_table_fields=['photo_id','author','body'];

    public function create(){
        global $database;
        //now get the array of properties from the calling object so that we can implode and use key and array
        $properties= $this->clean_properties();
        $keys=implode(",",array_keys($properties));
        $values=implode("','",array_values($properties));

        $sql= "INSERT INTO ".self::$db_table_name." (".$keys." ) VALUES ('".$values."')";
        if($database->query($sql)){
            return true;
        }else{
            return false;
        }

    }//end of create method

    public function properties(){
        //now create associative array from object so that key and value can be used in sql
        $properties= array();
        foreach (self::$db_table_fields as $db_table_field){
            if(property_exists($this,$db_table_field)){
                $properties[$db_table_field]= $this->$db_table_field;
            }
        }
        return $properties;
    }//end of properties
    //now clean the properties

    public function clean_properties(){
        global $database;
        $clean_properties=array();

        foreach($this->properties() as $key=>$value){
            $clean_properties[$key]= $database->realEscapeString($value);

        }
        return $clean_properties;
    }//end of clean_properties

    public function update_by_id(){
        global $database;
        $properties_to_clean=$this->clean_properties();
        $clean_properties_values=array();
        foreach($properties_to_clean as $key=>$value){
            $clean_properties_values[]= "{$key} = '{$value}'";

        }


         $sql="UPDATE " .self::$db_table_name." SET ".implode(",",$clean_properties_values). " WHERE id=".$database->realEscapeString($this->id);

        if($database->query($sql)){
            return mysqli_affected_rows($database->connection)==1 ? true:false;
        }
    }//end of update_by_id method

    public function delete_by_id(){

        global $database;
        $sql= "DELETE FROM ".self::$db_table_name." WHERE id =".$database->realEscapeString($this->id);
        if($database->query($sql)){
            return mysqli_affected_rows($database->connection)==1 ? true:false;
        }
    }//end of delete_by_id

    public function find_all(){
        global $database;
        $sql= "SELECT * FROM ".self::$db_table_name;
        return self::submit_query($sql);

    }//end of find_all

    public function find_by_id($id){
        global $database;
        $sql="SELECT * FROM ".self::$db_table_name." WHERE id = ".$database->realEscapeString($id)." LIMIT 1";
        $all_obj_arr= self::submit_query($sql);
        return !empty($all_obj_arr)? array_shift($all_obj_arr) :false;
    }//end of find_by_id

    public static function find_by_photo_id($photo_id = 0){
        global $database;
        $sql="SELECT * FROM ".self::$db_table_name." WHERE photo_id = ".$database->realEscapeString($photo_id)." ORDER BY photo_id ASC";
        return self::submit_query($sql);

    }

    protected  static function submit_query($sql){
        global $database;
        $result=$database->query($sql);
        $obj_arr= array();
        while($row=mysqli_fetch_array($result)){
            $obj_arr[]= self::make_obj_from_arr($row);
        }
        return $obj_arr;

    }

    protected  static function make_obj_from_arr($ass_arr){
        $new_object= new self;
        foreach($ass_arr as $key=>$value){

            if($new_object->hasProperty($key)){
                $new_object->$key=$value;
            }


        } return $new_object;
    }//end of make_obj_from_arr

    protected  function hasProperty($key){
        $objectPropertiesList= get_object_vars($this);
        return array_key_exists($key,$objectPropertiesList) ? true:false;
    }

    public static function find_total(){
        global $database;
        $sql="SELECT COUNT(*) FROM ". self::$db_table_name;
        $result=$database->query($sql);
        $row=mysqli_fetch_array($result);
        return array_shift($row);

    }//end of find_total

}//end of Comment class


?>