<?php
error_reporting(E_ALL);
include('config.php');
include('libs/functions.php');
//if (version_compare(phpversion(), '7.0', '>')) include('libs/mysql_7.php');
include('libs/Sql.php');
include('libs/MySql.php');
include('libs/PostgreSql.php');


try
{    

//testing mysql
$obj = new MySql();
$res = array();

//insert1
$setAr = array('key'=>'user15_2_08','data'=>'testing_1my');
$resInsertMySql = 
        $obj->setTableName(TABLE_MY)->
                insert()->
                from()->
                setting($setAr)->
                setUniqueRecord(array('key'=>'user15_2_08'))->
                exec();


//insert2
$setAr = array('key'=>'user15_2_08','data'=>'testing_2my');
$resInsertMySql = 
        $obj->setTableName(TABLE_MY)->
        insert()->
        from()->
        setting($setAr)->
        setUniqueRecord(array('key'=>'user15_2_08'))->
        exec();


//select
$resSelectMySqlAfterInsert = 
        $obj->setTableName(TABLE_MY)->
                select(array('key', 'data'))->
                from()->where("`key` = 'user15_2_08'")->
                exec()->
                getAssoc();
if($resSelectMySqlAfterInsert !== false)
    $res [] = array('operation'=>'insert','result'=>$resSelectMySqlAfterInsert);
   

//update
$resUpdateMySql = 
        $obj->setTableName(TABLE_MY)->
        update()->
        from()->
        set(array('data'=>'update record'))->
        where("`key` = 'user15_2_08'")->
        exec();


//update
$resUpdateMySql = 
        $obj->setTableName(TABLE_MY)->
        update()->
        from()->
        set(array('data'=>'testing 111'))->
        where("`key` = 'user15_2_08 AND 'data'=>'testing_1my'")->
        exec();


//select
$resSelectMySqlAfterUpdate = 
        $obj->setTableName(TABLE_MY)->
        select(array('key', 'data'))->
        from()->
        where("`key` = 'user15_2_08'")->
        exec()->
        getAssoc();
if($resSelectMySqlAfterUpdate !== false)
    $res [] = array('operation'=>'update','result'=>$resSelectMySqlAfterUpdate);
    

//delete
$resDeleteMySql =  
        $obj->setTableName(TABLE_MY)->
        delete()->
        from()->
        where("`key` = 'user15_2_08'")->
        exec();


//delete
$resDeleteMySql =  
        $obj->setTableName(TABLE_MY)->
        delete()->
        from()->
        where("`key` = 'user15_2_08 AND 'data'=>'testing_1'")->
        exec();


//selectDelete
$resSelectMySqlAfterDelete = 
        $obj->setTableName(TABLE_MY)->
        select(array('key', 'data'))->
        from()->
        where("`key` = 'user15_2_08'")->
        exec()->
        getAssoc();
if($resSelectMySqlAfterDelete !== false)
    $res [] = array('operation'=>'delete','result'=>$resSelectMySqlAfterDelete);
    



////testing pgmysql
$objPg = new PosgreSql();
$resPg = array();

//
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
 

}
catch(Exception $ex)
{
    setFlash($ex->getMessage(),'fail');
}
 
$flashMessage = getFlash();   
include("templates/index.php");