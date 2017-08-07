<?php 
include ('config.php');

spl_autoload_register(function($className){
        $file =  'libs/'.$className.'.php';
        if(!file_exists($file)){
            throw new Exception("$file not found".PHP_EOL.__FILE__." - in line:".__LINE__.PHP_EOL);
        }
        require_once $file;
});

try
{
  $obj = new Controller();
  
}
catch(Exception $e)
{
  file_put_contents('error.txt', $e->getMessage(), FILE_APPEND);
  include('error.html');           
}







