<?php

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
$setAr = array('key'=>'user15','data'=>'testing_1');
$resInsertMySql = $obj->setTableName('MY_TEST')->insert()->from()->setting($setAr)->setUniqueRecord(array('key'=>'user15'))->exec();


//insert2
$setAr = array('key'=>'user15','data'=>'testing_2');
$resInsertMySql = $obj->setTableName('MY_TEST')->insert()->from()->setting($setAr)->setUniqueRecord(array('key'=>'user15'))->exec();


//select
$resSelectMySqlAfterInsert = $obj->setTableName('MY_TEST')->select(array('key', 'data'))->from()->where("`key` = 'user15'")->exec()->getAssoc();
if($resSelectMySqlAfterInsert !== false)
    $res [] = array('operation'=>'insert','result'=>$resSelectMySqlAfterInsert);
   

//update
$resUpdateMySql = $obj->setTableName('MY_TEST')->update()->from()->
                        set(array('data'=>'update record'))->
                        where("`key` = 'user15'")->
                        exec();


//update
$resUpdateMySql = $obj->setTableName('MY_TEST')->update()->from()->
                        set(array('data'=>'testing 111'))->
                        where("`key` = 'user15 AND 'data'=>'testing_1'")->
                        exec();


//select
$resSelectMySqlAfterUpdate = $obj->setTableName('MY_TEST')->select(array('key', 'data'))->from()->where("`key` = 'user15'")->exec()->getAssoc();
if($resSelectMySqlAfterUpdate !== false)
    $res [] = array('operation'=>'update','result'=>$resSelectMySqlAfterUpdate);
    

//delete
$resDeleteMySql =  $obj->setTableName('MY_TEST')->delete()->from()->where("`key` = 'user15'")->exec();


//delete
$resDeleteMySql =  $obj->setTableName('MY_TEST')->delete()->from()->where("`key` = 'user15 AND 'data'=>'testing_1'")->exec();


//selectDelete
$resSelectMySqlAfterDelete = $obj->setTableName('MY_TEST')->select(array('key', 'data'))->from()->where("`key` = 'user15'")->exec()->getAssoc();
if($resSelectMySqlAfterDelete !== false)
    $res [] = array('operation'=>'delete','result'=>$resSelectMySqlAfterDelete);
    



////testing pgmysql
$objPg = new PosgreSql();
$resPg = array();

//
//insert1
$setAr = array('key'=>'user15_1_08','data'=>'testing1pg');
$resInsertPgSql = $objPg->setTableName(TABLE_PG)->insert()->from()->setting($setAr)->setUniqueRecord(array('key'=>'user15_1_08'))->exec();

//insert2
$setAr = array('key'=>'user15_1_08','data'=>'testing2pg');
$resInsertPgSql = $objPg->setTableName(TABLE_PG)->insert()->from()->setting($setAr)->setUniqueRecord(array('key'=>'user15_1_08'))->exec();

//select
$resSelectPgSqlAfterInsert = $objPg->setTableName(TABLE_PG)->select(array('key', 'data'))->from()->where("\"key\" = 'user15_1_08'")->exec()->getAssoc();
if($resSelectPgSqlAfterInsert !== false)
    $resPg [] = array('operation'=>'insert','result'=>$resSelectPgSqlAfterInsert);
    
//
//update
$resUpdatePgSql = $objPg->setTableName(TABLE_PG)->update()->from()->
                        set(array('data'=>'update record'))->
                        where("\"key\" = 'user15_1_08'")->
                        exec();


//update
$resUpdatePgSql = $objPg->setTableName(TABLE_PG)->update()->from()->
                        set(array('data'=>'update record pg'))->
                        where("\"key\" = 'user15_1_08' AND \"data\"='testing1pg'")->
                        exec();

//select
$resSelectPgSqlAfterUpdate = $objPg->setTableName(TABLE_PG)->select(array('key', 'data'))->from()->where("\"key\" = 'user15_1_08'")->exec()->getAssoc();
if($resSelectPgSqlAfterUpdate !== false)
    $resPg [] = array('operation'=>'update','result'=>$resSelectPgSqlAfterUpdate);
   


//delete
$resDeletePgSql =  $objPg->setTableName(TABLE_PG)->delete()->from()->where("\"key\" = 'user15_1_08' AND `data`='update record pg'")->exec();


//selectDelete
$resSelectPgSqlAfterDelete = $objPg->setTableName(TABLE_PG)->select(array('key', 'data'))->from()->where("\"key\" = 'user15_1_08'")->exec()->getAssoc();
if($resSelectPgSqlAfterDelete !== false)
    $resPg [] = array('operation'=>'delete','result'=>$resSelectMySqlAfterDelete);
    





include('templates/index.php');

}
catch(Exception $ex)
{
    echo $ex->getMessage();
}