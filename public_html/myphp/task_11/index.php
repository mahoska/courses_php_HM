<?php 
include('config.php');
include('libs/functions.php');

spl_autoload_register(function($className){
        $file =  'libs/'.$className.'.php';
        if(!file_exists($file)){
            throw new Exception("$file not found".PHP_EOL.__FILE__.PHP_EOL."- in ".__LINE__.PHP_EOL);
        }
        require_once $file;
});

$obj = new MySql();

$setAr = array('key'=>'user222','data'=>'333');
$resInsertMySql = 
        $obj->
                insert()->
                from()->
                setting($setAr)->
                setUniqueRecord(array('key'=>'user222'))->
                exec();



//$obj = new ActiveRecord();
//$obj->data = 'test';       
//echo  $obj->data;       

//var_dump(isset($obj->key)); 

try {

  
} catch (Exception $ex) {
    setFlash($ex->getMessage(),'fail');
}

$flashMessage = getFlash();  
include('templates/index.php');