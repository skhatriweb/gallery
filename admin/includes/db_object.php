<?php

class Db_object{

    public static function find_all(){
        //following will return result array
        return static::find_this_query("SELECT * FROM ".static::$db_table);

    }//end of find_all
    public static function find_by_id($id){

        $the_result_array= static::find_this_query("SELECT * FROM ".static::$db_table." WHERE id =$id LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) :false;


    }//end of find_by_id

    public static function find_this_query($sql){
        global $database;
        $result=$database->query($sql);
        //this is very important to create new array and put all the objects into that so that you can loop in index
        $the_object_array= array();
        while($row=mysqli_fetch_array($result)){
            $the_object_array[]=static::instantiation($row);

        }
        return $the_object_array;
    }//end of find_this_query

    public static function instantiation($row){
        $calling_class=get_called_class();
        $the_object= new $calling_class;

        foreach($row as $key => $value){
            if($the_object->object_has_attribute($key)){
                $the_object->$key =$value;
            }

        }
        return $the_object;


    }//end of instantiation method

    private  function object_has_attribute($key){
        $classProperties = get_object_vars($this);
        return (array_key_exists($key,$classProperties));

    }//end of object has attribute

    protected function clean_properties(){
        global $database;
        $clean_properties=array();
        foreach($this->properties() as $key=>$value){
            $clean_properties[$key]=$database->realEscapeString($value);
        }
        return $clean_properties;
    }//end of clean_properties method

    private function properties(){
        //new array for object  properties
        $properties= array();

        foreach(static::$db_table_fields as $db_field){
            if(property_exists($this,$db_field)){
                //all properties are stored in array key db_table_fields
                $properties[$db_field] = $this->$db_field;
            }

        }
        return $properties;

    }//end of properties method

    public function create(){
        global $database;
        $properties= $this->clean_properties();
        // $keys= implode(",",array_keys($properties));
        // $values=implode("','",array_values($properties));
        $sql="INSERT INTO ".static::$db_table."(".implode(",",array_keys($properties)).")";
        $sql.="VALUES ('".implode("','",array_values($properties))."')";
        if($database->query($sql)){
            $this->id= $database->insertId();
            return true;
        }else{
            return false;
        }

    }//end of creates

    public function update(){
        global $database;
        $properties= $this->clean_properties();
        $properties_key_value= array();
        foreach($properties as $key=>$value){

            $properties_key_value[]= "{$key}='{$value}'";

        }

        $sql= "UPDATE ".static::$db_table." SET ".implode(',',$properties_key_value);
        $sql.=" WHERE id =".$database->realEscapeString($this->id);

        if($database->query($sql)){
            return mysqli_affected_rows($database->connection)== 1 ? true:false;
        }

    }//end of update

    public function delete(){
        global $database;
        $sql= "DELETE from ".static::$db_table." WHERE id= ".$database->realEscapeString($this->id)." LIMIT 1";
        if($database->query($sql)){
            return mysqli_affected_rows($database->connection)==1 ? true:false;
        }
    }//end of delete

    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
    }//end of save

   /* public $upload_errors_array = array(

        UPLOAD_ERR_OK=>"File uploaded successfully.",
        UPLOAD_ERR_INI_SIZE=>"The uploaded file size exceeds upload_max_fileSize directive in PHP.INI.",
        UPLOAD_ERR_FORM_SIZE=>"The uploaded file size exceeds the max_file_size directive in PHP.INI.",
        UPLOAD_ERR_PARTIAL=>"The uploaded file only partially uploaded.",
        UPLOAD_ERR_NO_FILE=>"No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR=>"Missing temporary folder.",
        UPLOAD_ERR_CANT_WRITE=>"The uploaded file can not be written to disk.",
        UPLOAD_ERR_EXTENSION=>"The PHP extension stopped file upload.",
    ) ;//end of upload_errors_array*/

    public function set_file($file){

        if(!$file || !is_array($file) || empty($file) ){
            $this->errors[]="There is no file uploaded ";
            return false;
        }
        if($file['error'] != 0){

            $this->errors[]=$file['error'];
            return false;
        }
        $this->tmp_path= $file['tmp_name'];
        $this->filename= basename($file['name']);
        //Note:photo class has size and type property but this one (user) does not have size and type so return trur
        $calling_class= get_called_class();
       //condition to assign type and size property to photo object
        if($calling_class == 'User' ){
            return true;
        }else{
            $this->type=$file['type'];
            $this->size=$file['size'];
            return true;
        }


    }//end of set_file method

    public function  save_image(){


            if(!empty($this->errors)){
                return false;
            }
            if(empty($this->filename ) || empty($this->tmp_path)){
                $this->errors[]="The file is not  available for  upload";
                return false;
            }

            $target_path= SITE_ROOT.DS."admin".DS.$this->upload_directory.DS.$this->filename;

            if(file_exists($target_path)){
                $this->errors[]="the file". $this->filename ." already exists";
                return false;
            }
            if(move_uploaded_file($this->tmp_path,$target_path)){

                    unset($this->tmp_path);
                    return true;

            }else{
                $this->errors[]="Ops! Looks like some issue with destination folder permission" ;
                return false;
            }

    }//end of save_obj method

    public function delete_obj(){

        if($this->delete()){

            $target_file_path= SITE_ROOT.DS.'admin'.DS.$this->upload_directory.DS.$this->filename;
            return unlink($target_file_path) ? true:false;


        }else{
            return false;
        }

    }//end of delete_obj

    public static function find_total(){
        global $database;
        $sql="SELECT COUNT(*) FROM ". static::$db_table;
        $result=$database->query($sql);
        $row=mysqli_fetch_array($result);
        return array_shift($row);

    }//end of find_total









}//end of class Db_object

?>