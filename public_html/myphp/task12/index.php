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

$obj = new MyPdo(MYSQL);
$tableName = 'MY_TEST';
$res  = [];

//insert1
$setAr = array('key'=>'user151_t12','data'=>'testing_1my');
$resInsertMySql = 
        $obj->insert($setAr)->
        from($tableName)->
        setting()->
        setUniqueRecord(array('key'=>'user151_t12'))->
        exec();


//insert2
$setAr = array('key'=>'user152_t12','data'=>'testing_2my');
$resInsertMySql = 
        $obj->insert($setAr)->
        from($tableName)->
        setting()->
        setUniqueRecord(array('key'=>'user152_t12'))->
        exec();

//select
$resSelectMySqlAfterInsert = 
        $obj->select(array('key', 'data'))->
                from($tableName)->
                where("`key` = :key", array('key'=>'user151_t12'))->
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
        where("`key` = :keyCond", array('keyCond'=>'user151_t12'))->
        exec();

//update
$resUpdateMySql = 
        $obj->update()->
        from($tableName)->
        set(array('data'=>'testing task12'))->
        where("`key` = :keyCond AND `data` = :dataCond", array('keyCond'=>'user152_t12', 'dataCond'=>'testing_2my' ))->
        exec();


//select
$resSelectMySqlAfterUpdate = 
        $obj->select(array('key', 'data'))->
        from($tableName)->
        where("`key` = :keyCond", array('keyCond' => 'user152_t12'))->
        exec()->
        getAssoc();
if($resSelectMySqlAfterUpdate !== false)
    $res [] = array('operation'=>'update','result'=>$resSelectMySqlAfterUpdate);


   
//delete
$resDeleteMySql =  
        $obj->delete()->
        from($tableName)->
        where("`key` = :keyCond", array('keyCond' => 'user151_t12'))->
        exec();

//delete
$resDeleteMySql =  
        $obj->delete()->
        from($tableName)->
        where("`key` = :keyCond AND `data` = :dataCond", array('keyCond'=>'user152_t12', 'dataCond'=>'testing task12' ))->
        exec();


//selectDelete
$resSelectMySqlAfterDelete = 
        $obj->select(array('key', 'data'))->
        from($tableName)->
        where("`key` = :keyCond", array('keyCond' => 'user152_t12'))->
        exec()->
        getAssoc();
if($resSelectMySqlAfterDelete !== false)
    $res [] = array('operation'=>'delete','result'=>$resSelectMySqlAfterDelete);
    


////testing pgmysql
$objPg = new MyPdo(PGSQL);
$resPg = array();
/*
//insert1
$setAr = array('key'=>'user15_2_08','data'=>'testing1pg');
$resInsertPgSql = 
        $objPg->setTableName(TABLE_PG)->
                insert()->
                from()->
                setting($setAr)->
                setUniqueRecord(array('key'=>'user15_2_08'))->
                exec();
//insert2
$setAr = array('key'=>'user15_2_08','data'=>'testing2pg');
$resInsertPgSql = 
        $objPg->setTableName(TABLE_PG)->
                insert()->
                from()->
                setting($setAr)->
                setUniqueRecord(array('key'=>'user15_2_08'))->
                exec();
//select
$resSelectPgSqlAfterInsert = 
        $objPg->setTableName(TABLE_PG)->
                select(array('key', 'data'))->
                from()->
                where("\"key\" = 'user15_2_08'")->
                exec()->
                getAssoc();
if($resSelectPgSqlAfterInsert !== false)
    $resPg [] = array('operation'=>'insert','result'=>$resSelectPgSqlAfterInsert);
    
//
//update
$resUpdatePgSql = 
        $objPg->setTableName(TABLE_PG)->
                update()->
                from()->
                set(array('data'=>'update record'))->
                where("\"key\" = 'user15_2_08'")->
                exec();
//update
$resUpdatePgSql = 
        $objPg->setTableName(TABLE_PG)->
                update()->from()->
                set(array('data'=>'update record pg'))->
                where("\"key\" = 'user15_2_08' AND \"data\"='testing1pg'")->
                exec();
//select
$resSelectPgSqlAfterUpdate = 
        $objPg->setTableName(TABLE_PG)->
                select(array('key', 'data'))->
                from()->
                where("\"key\" = 'user15_2_08'")->
                exec()->
                getAssoc();
if($resSelectPgSqlAfterUpdate !== false)
    $resPg [] = array('operation'=>'update','result'=>$resSelectPgSqlAfterUpdate);
   
//delete
$resDeletePgSql =  $objPg->
        setTableName(TABLE_PG)->
        delete()->
        from()->
        where("\"key\" = 'user15_2_08'")->
        exec();
//delete
$resDeletePgSql =  
        $objPg->setTableName(TABLE_PG)->
        delete()->
        from()->
        where("\"key\" = 'user15_2_08' AND \"data\"='update record pg'")->
        exec();
//selectDelete
$resSelectPgSqlAfterDelete = 
        $objPg->setTableName(TABLE_PG)->
                select(array('key', 'data'))->
                from()->
                where("\"key\" = 'user15_2_08'")->
                exec()->
                getAssoc();
if($resSelectPgSqlAfterDelete !== false)
    $resPg [] = array('operation'=>'delete','result'=>$resSelectMySqlAfterDelete);
 
*/

try {

} catch (PDOException $ex) {
    setFlash($ex->getMessage(),'fail');
    file_put_contents('PDOErrors.txt', $ex->getMessage(), FILE_APPEND); 
}

$flashMessage = getFlash();  
include('templates/index.php');