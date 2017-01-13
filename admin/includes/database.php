<?php

class Database {
    
    public $connection;
    
        
    public function open_db_connection(){
        
        $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        
        if($this->connection->connect_errno){
            
            die("Database connection error ".$this->connection->connect_error);
            
        }

    }
    function __construct(){
        $this->open_db_connection();
    }


    public function query($sql){
        
        $result= $this->connection->query($sql);
        if(!$result){
            die("Query failed ".$this->connection->error);
        }else{
            return $result;
        }



   
    }
    
    /*public function confirm_query($result){
        if(!$result){
            die("Query failed ".$this->connection->error);
        }

    }*/

    public function insertId(){

        return $this->connection->insert_id;
    }
    public  function realEscapeString($string){
        return mysqli_real_escape_string($this->connection,$string);
    }


}


$database = new Database();
?>