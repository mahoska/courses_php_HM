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

try {

    $obj = new ActiveRecord();
    tesingDelete();
    
    $res1 = tesingSelect();
    $init = array('key'=>$obj->key, 'data'=>$obj->data, 'unique'=>$obj->getUnique(),  'selection'=>$res1); 
    
    //testing save
    $descr = array();
    $obj->setUnique('key');
    $obj->key = 'user15_test11_1';  
    $obj->save();//error
    $descr[] = array('oper'=>'save', 'key'=>$obj->key, 'data'=>$obj->data, 'unique'=>$obj->getUnique());
    
    $obj->data = 'testing_task_11'; 
    $obj->save();//ok
    $descr[] = array('oper'=>'save', 'key'=>$obj->key, 'data'=>$obj->data, 'unique'=>$obj->getUnique());
    
    $obj->save();//error
    $descr[] = array('oper'=>'save', 'key'=>$obj->key, 'data'=>$obj->data, 'unique'=>$obj->getUnique());
    
    $obj->setUnique('key');
    $obj->setRecord(array('key'=>'user15_test11_2','data'=>'testing_task_11'));
    $obj->save();//ok
    
    $res2 = tesingSelect();
    $descr[] = array('oper'=>'save', 'key'=>$obj->key, 'data'=>$obj->data, 'unique'=>$obj->getUnique(), 'selection'=>$res2);
    
      
    //testing find
    $descrF = array();
    $resFind = $obj->find("`key` = 'user15_test11_1'");
    $descrF[] = array('oper'=>'find', 'condition'=>"`key` = 'user15_test11_1'", 'res'=>$resFind->getRecord());
    
    $resFind = $obj->find("`user` = 'user15_test11_1'");
    $descrF[] = array('oper'=>'find', 'condition'=>"`user` = 'user15_test11_1'", 'res'=>$resFind->getRecord());
    
    $resFind = $obj->findAll("`key` LIKE 'user15_test%'");
    $descrF[] = array('oper'=>'findAll', 'condition'=>"`key` LIKE 'user15_test%'", 'res'=>$resFind);

 
    //testing delete
    $res = $obj->find("`key` = 'user15_test11_2'");
    $res->delete();
    $res3 = tesingSelect();
    $descrD[] = array('oper'=>'delete', 'condition'=>"`key` = 'user15_test11_2'", 'selection'=>$res3);
    
    
    //testing update
    $obj->setRecord(array('key'=>'up_user15_test11_1','data'=>'update_befor'));
    $obj->save();//ok
    $obj->setRecord(array('key'=>'up_user15_test11_2','data'=>'update'));
    $obj->save();
    
    $res = $obj->find("`key` = 'up_user15_test11_1'");
    $res->update(array('data'=>'after update'));
    $res4 = $obj->find("`key` = 'up_user15_test11_1'");
    $descrD[] = array('oper'=>'update record', 'condition'=>"`key` = 'up_user15_test11_1'", 'selection'=>$res4->getRecord());
    
    
 
  
    $obj->updateAll(array('data'=>'all update'),"`key`  LIKE 'up_user15_test%'");
    $res6 = tesingSelectD();
    $descrD[] = array('oper'=>'updateAll', 'condition'=>"`key`  LIKE 'up_user15_test%'", 'selection'=>$res6);
   
   
//        echo"<pre>";
//    var_dump($descr);
//    echo"</pre>";
    
} catch (Exception $ex) {
    setFlash($ex->getMessage(),'fail');
}

$flashMessage = getFlash();  
include('templates/index.php');