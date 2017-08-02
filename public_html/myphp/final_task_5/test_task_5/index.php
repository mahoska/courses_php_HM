<?php
session_start();

include('config.php');
include('libs/functions.php');
//include('libs/iData.php');
//include('libs/DbConnection.php');
//include('libs/MySql.php');
//include('libs/PgSql.php');
//include('libs/SessionData.php');
//include('libs/CookieData.php');

spl_autoload_register(function($className){
        $file =  'libs/'.$className.'.php';
        if(!file_exists($file)){
            throw new Exception("$file not found".PHP_EOL.__FILE__.PHP_EOL."- in ".__LINE__.PHP_EOL);
        }
        require_once $file;
    });

try {
    $obj = new MySql();
    $messages = [];
    $key = 'user15_5';
    $messages[] = $obj->setData($key,'task 5 testing insert') ? 
            ['mes'=>'insert record by key = '.$key.' and value = "task 5 testing insert"','status'=>'success'] : 
            ['mes'=> ERROR_OPER.' insert', 'status'=>'fail']; 
    $resSel = $obj->readData($key);
        $messages[] = $resSel !== false ?  ['mes'=>'found value = "'.$resSel.'" by key = '.$key,'status'=>'success'] :
             ['mes'=> ERROR_OPER.' - not found record with  key = '.$key, 'status'=>'fail'];  
        
    $messages[] = $obj->setData($key,'task 5 testing update') ? 
            ['mes'=>'update record by key = '.$key,'status'=>'success'] :
            ['mes'=> ERROR_OPER.' update', 'status'=>'fail'];  
    $resSel = $obj->readData($key);
       $messages[] = $resSel !== false ?  
             ['mes'=>'found value = "'.$resSel.'" by key = '.$key,'status'=>'success'] :
             ['mes'=> ERROR_OPER.' - not found record with  key = '.$key, 'status'=>'fail']; 
        
    $messages[] = $obj->deleteData($key) ?
            ['mes'=>'delete record by key = '.$key,'status'=>'success'] :
            ['mes'=> ERROR_OPER.' delete', 'status'=>'fail']; 
    
    $resSel = $obj->readData($key);
        $messages[] = $resSel !== false ? 
             ['mes'=>'found value = "'.$resSel.'" by key = '.$key,'status'=>'success'] :
             ['mes'=> ERROR_OPER.' - not found record with  key = '.$key, 'status'=>'fail']; 
    
        
    $resSes = [];    
    $objSes = new SessionData();
    $keyS = 'test_session';
    $objSes->setData($keyS, 111);
    $resS = $objSes->readData($keyS);
    $resSes[] = !is_null($resS)?'session value  = '.$resS : 'uncorrect session key';
    $objSes->deleteData($keyS);
    $resS = $objSes->readData($keyS);
    $resSes[] = !is_null($resS)?'session value  = '.$resS : 'uncorrect session key';
    
    $resCook = [];    
    $objCook = new CookieData();
    $keyC = 'test_cookie';
    $objCook->setData($keyC, 111);
    $resC = $objCook->readData($keyC);
    $resCook[] = !is_null($resC)?'cookie value  = '.$keyC : 'uncorrect cookie key';
    $objCook->deleteData($keyC);
    $resC = $objCook->readData($keyC);
    $resCook[] = !is_null($resC)?'cookie value  = '.$keyC : 'uncorrect cookie key';
    
  
   
//    $objP = new PgSql();
//    $messagesP = [];
//    $key = 'user15_5_pg'; 
//    $messagesP[] = $objP->setData($key,'task 5 testing pg_insert') ? 
//            ['mes'=>'pg_insert record by key = '.$key.' and value = "task 5 testing pg_insert"','status'=>'success'] : 
//            ['mes'=> ERROR_OPER.' pg_insert', 'status'=>'fail']; 
//    $resSelP = $objP->readData($key);
//        $messagesP[] = $resSelP !== false ?  ['mes'=>'found value = "'.$resSelP.'" by key = '.$key,'status'=>'success'] :
//             ['mes'=> ERROR_OPER.' - not found pg_record with  key = '.$key, 'status'=>'fail'];  
//        
//    $messagesP[] = $objP->setData($key,'task 5 testing update') ? 
//            ['mes'=>'pg_update record by key = '.$key,'status'=>'success'] :
//            ['mes'=> ERROR_OPER.' update', 'status'=>'fail'];  
//    $resSelP = $objP->readData($key);
//       $messagesP[] = $resSelP !== false ?  
//             ['mes'=>'found value = "'.$resSelP.'" by key = '.$key,'status'=>'success'] :
//             ['mes'=> ERROR_OPER.' - not found pg_record with  key = '.$key, 'status'=>'fail']; 
//        
//    $messagesP[] = $objP->deleteData($key) ?
//            ['mes'=>'pg_delete record by key = '.$key,'status'=>'success'] :
//            ['mes'=> ERROR_OPER.' pg_delete', 'status'=>'fail']; 
//    
//    $resSelP = $objP->readData($key);
//        $messagesP[] = $resSelP !== false ? 
//             ['mes'=>'found value = "'.$resSelP.'" by key = '.$key,'status'=>'success'] :
//             ['mes'=> ERROR_OPER.' - not found pg_record with  key = '.$key, 'status'=>'fail']; 
//     
//    
} catch (Exception $ex) {
    setFlash($ex,'fail');
}

include('templates/index.php');