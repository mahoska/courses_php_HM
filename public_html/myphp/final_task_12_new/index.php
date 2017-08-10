<?php 
error_reporting(E_ALL);
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

tesingDelete(MYSQL);   
    
$obj = new MyPdo(MYSQL);
$tableName = 'MY_TEST';
$res  = [];

//insert1
$setAr = array('key'=>'user15_t12_1','data'=>'testing_1my');
$resInsertMySql = 
        $obj->insert($setAr)->
        from($tableName)->
        setting()->
        setUniqueRecord(array('key'=>'user15_t12_1'))->
        exec();


//insert2
$setAr = array('key'=>'user15_t12_2','data'=>'testing_2my');
$resInsertMySql = 
        $obj->insert($setAr)->
        from($tableName)->
        setting()->
        setUniqueRecord(array('key'=>'user15_t12_2'))->
        exec();

//select
$resSelectMySqlAfterInsert = 
        $obj->select(array('key', 'data'))->
                from($tableName)->
                where("`key` LIKE 'user15_t12%'")->
                exec()->
                getAssoc();

if($resSelectMySqlAfterInsert !== false)
    $res [] = array('operation'=>'insert','result'=>$resSelectMySqlAfterInsert);

//var_dump($resSelectMySqlAfterInsert);

//update
$resUpdateMySql = 
        $obj->update()->
        from($tableName)->
        set(array('data'=>'update record'))->
        where("`key` = :keyCond", array('keyCond'=>'user15_t12_1'))->
        exec();

//update
$resUpdateMySql = 
        $obj->update()->
        from($tableName)->
        set(array('data'=>'testing task12'))->
        where("`key` = :keyCond AND `data` = :dataCond", array('keyCond'=>'user15_t12_2', 'dataCond'=>'testing_2my' ))->
        exec();


//select
$resSelectMySqlAfterUpdate = 
        $obj->select(array('key', 'data'))->
        from($tableName)->
        where("`key` LIKE 'user15_t12%'")->
        exec()->
        getAssoc();
if($resSelectMySqlAfterUpdate !== false)
    $res [] = array('operation'=>'update','result'=>$resSelectMySqlAfterUpdate);


   
//delete
$resDeleteMySql =  
        $obj->delete()->
        from($tableName)->
        where("`key` = :keyCond", array('keyCond' => 'user15_t12_1'))->
        exec();

//delete
$resDeleteMySql =  
        $obj->delete()->
        from($tableName)->
        where("`key` = :keyCond AND `data` = :dataCond", 
        array('keyCond'=>'user15_t12_2', 'dataCond'=>'testing task12' ))->
        exec();


//selectDelete
$resSelectMySqlAfterDelete = 
        $obj->select(array('key', 'data'))->
        from($tableName)->
        where("`key` LIKE  'user15_t12%'")->
        exec()->
        getAssoc();
if($resSelectMySqlAfterDelete !== false)
    $res [] = array('operation'=>'delete','result'=>$resSelectMySqlAfterDelete);
    

tesingDelete(PGSQL); 

////testing pgmysql
$objPg = new MyPdo(PGSQL);
$resPg = array();
$ptableName = 'PG_TEST';

//insert1
$setAr = array('key'=>'user15_t12_1','data'=>'testing_1pg');
$resInsertPgSql = 
        $objPg->insert($setAr)->
        from($ptableName)->
        setting()->
        setUniqueRecord(array('key'=>'user15_t12_1'))->
        exec();


//insert2
$setAr = array('key'=>'user15_t12_2','data'=>'testing_2pg');
$resInsertPgSql = 
        $objPg->insert($setAr)->
        from($ptableName)->
        setting()->
        setUniqueRecord(array('key'=>'user15_t12_2'))->
        exec();

//select
$resSelectPgSqlAfterInsert = 
        $objPg->select(array('key', 'data'))->
                from($ptableName)->
                where("key  LIKE 'user15_t12%'")->
                exec()->
                getAssoc();

if($resSelectPgSqlAfterInsert !== false)
    $resPg [] = array('operation'=>'insert','result'=>$resSelectPgSqlAfterInsert);

//var_dump($resSelectMySqlAfterInsert);

//update
$resUpdatePgSql = 
        $objPg->update()->
        from($ptableName)->
        set(array('data'=>'update record'))->
        where("key = :keyCond", array('keyCond'=>'user15_t12_1'))->
        exec();

//update
$resUpdatePgSql = 
        $objPg->update()->
        from($ptableName)->
        set(array('data'=>'testing task12'))->
        where("key = :keyCond  AND data = :dataCond", array('keyCond'=>'user15_t12_2', 'dataCond'=>'testing_2pg' ))->
        exec();


//select
$resSelectPgSqlAfterUpdate = 
        $objPg->select(array('key', 'data'))->
        from($ptableName)->
        where("key LIKE 'user15_t12%'")->
        exec()->
        getAssoc();
if($resSelectPgSqlAfterUpdate !== false)
    $resPg [] = array('operation'=>'update','result'=>$resSelectPgSqlAfterUpdate);


   
//delete
$resDeletePgSql =  
        $objPg->delete()->
        from($ptableName)->
        where("key = :keyCond", array('keyCond' => 'user15_t12_1'))->
        exec();

//delete
$resDeletePgSql =  
        $objPg->delete()->
        from($ptableName)->
        where("key = :keyCond AND data = :dataCond", 
        array('keyCond'=>'user15_t12_2', 'dataCond'=>'testing task12' ))->
        exec();


//selectDelete
$resSelectPgSqlAfterDelete = 
        $objPg->select(array('key', 'data'))->
        from($ptableName)->
        where("key LIKE  'user15_t12%'")->
        exec()->
        getAssoc();
if($resSelectPgSqlAfterDelete !== false)
    $resPg [] = array('operation'=>'delete','result'=>$resSelectPgSqlAfterDelete);



} catch (PDOException $ex) {
    setFlash($ex->getMessage(),'fail');
    file_put_contents('PDOErrors.txt', $ex->getMessage(), FILE_APPEND); 
}

$flashMessage = getFlash();  
include('templates/index.php');
