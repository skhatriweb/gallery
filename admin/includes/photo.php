<?php

class Photo extends Db_object  {

    public $id;
    public $title;
    public $caption;
    public $description;
    public $filename;
    public $alternate_text;
    public $type;
    public $size;

    protected static $db_table="photos";
    protected static $db_table_fields= array('title','caption','description','filename','alternate_text','type','size');


    public $errors =array();
    public $upload_directory ="images";
    public $tmp_path;

    //$file= $_FILE['uploaded_file] and we are passing $file as an argument

    public function imagePath(){
        return $this->upload_directory.DS.$this->filename;
    }//end of imagePath method



}//end of Photo class

?>