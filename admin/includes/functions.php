<?php
function autoloadCustom($class){

    $class=strtolower($class);
    $the_path="includes/{$class}.php";

    if(file_exists($the_path)){

        require_once ($the_path);
    }else {

        die("The file {$class}.php  could not found man");
    }


}

spl_autoload_register('autoloadCustom');

function redirect($location){
    header("location:{$location}");
}

?>