<?php
error_reporting(E_ALL);
include('config.php');
include('libs/functions.php');

include('libs/Sql.php');
include('libs/MySql.php');
include('libs/PostgreSql.php');

try
{    
 
//testing mysql
$obj = new MySql();
$res = array();
$resArrectRow = array();


//insert1
$setAr = array('key'=>'user15','data'=>'testing_1');
$resInsertMySql = $obj->setTableName('MY_TEST')->insert()->from()->setting($setAr)->setUniqueRecord(array('key'=>'user15'))->exec()->getNumberAffectedRecords();


//insert2
$setAr = array('key'=>'user15','data'=>'testing_2');
$resInsertMySql = $obj->setTableName('MY_TEST')->insert()->from()->setting($setAr)->setUniqueRecord(array('key'=>'user15'))->exec()->getNumberAffectedRecords();


//select
$resSelectMySqlAfterInsert = $obj->setTableName('MY_TEST')->select(array('key', 'data'))->from()->where("`key` = 'user15'")->exec()->getAssoc();
if($resSelectMySqlAfterInsert === false)
    $resArrectRow[] = array('mes'=>"ERROR_SELECT", 'flag'=>"fail");
else
{
    $res [] = array('operation'=>'insert','result'=>$resSelectMySqlAfterInsert);
    $resSel = $obj->getNumberSelectedRecords();
    $resArrectRow[] = array('mes'=>"select $resSel record(s)", 'flag'=>'succes');
}

//update
$resUpdateMySql = $obj->setTableName('MY_TEST')->update()->from()->
                        set(array('data'=>'update record'))->
                        where("`key` = 'user15'")->
                        exec()->getNumberAffectedRecords();
if($resUpdateMySql > 0)
    $resArrectRow[] = array('mes'=>"updated $resUpdateMySql record(s)", 'flag'=>'succes');
else 
    $resArrectRow[] = array('mes'=>"ERROR_UPD", 'flag'=>"fail");

//update
$resUpdateMySql = $obj->setTableName('MY_TEST')->update()->from()->
                        set(array('data'=>'testing'))->
                        where("`key` = 'user15 AND 'data'=>'testing_1'")->
                        exec()->getNumberAffectedRecords();
if($resUpdateMySql > 0)
    $resArrectRow[] = array('mes'=>"updated $resUpdateMySql record(s)", 'flag'=>'succes');
else 
    $resArrectRow[] = array('mes'=>"ERROR_UPD", 'flag'=>"fail");

//select
$resSelectMySqlAfterUpdate = $obj->setTableName('MY_TEST')->select(array('key', 'data'))->from()->where("`key` = 'user15'")->exec()->getAssoc();
if($resSelectMySqlAfterUpdate === false)
    $resArrectRow[] = array('mes'=>"ERROR_SELECT", 'flag'=>"fail");
else
{
    $res [] = array('operation'=>'update','result'=>$resSelectMySqlAfterUpdate);
    $resSel = $obj->getNumberSelectedRecords();
    $resArrectRow[] = array('mes'=>"select $resSel record(s)", 'flag'=>'succes');
}

//delete
$resDeleteMySql =  $obj->setTableName('MY_TEST')->delete()->from()->where("`key` = 'user15'")->exec()->getNumberAffectedRecords();
if($resDeleteMySql > 0)
     $resArrectRow[] = array('mes'=>"deleted $resDeleteMySql record(s)", 'flag'=>'succes');
else 
    $resArrectRow[] = array('mes'=>"ERROR_DEL", 'flag'=>"fail");

//delete
$resDeleteMySql =  $obj->setTableName('MY_TEST')->delete()->from()->where("`key` = 'user15 AND 'data'=>'testing_1'")->exec()->getNumberAffectedRecords();
if($resDeleteMySql > 0)
     $resArrectRow[] = array('mes'=>"deleted $resDeleteMySql record(s)", 'flag'=>'succes');
else 
    $resArrectRow[] = array('mes'=>"ERROR_DEL", 'flag'=>"fail");




//selectDelete
$resSelectMySqlAfterDelete = $obj->setTableName('MY_TEST')->select(array('key', 'data'))->from()->where("`key` = 'user15'")->exec()->getAssoc();
if($resSelectMySqlAfterDelete === false)
    $resArrectRow[] = array('mes'=>"ERROR_SELECT", 'flag'=>"fail");
else
{
    $res [] = array('operation'=>'delete','result'=>$resSelectMySqlAfterDelete);
    $resSel = $obj->getNumberSelectedRecords();
    $resArrectRow[] = array('mes'=>"select $resSel record(s)", 'flag'=>'succes');
}
 


//testing pgmysql
$objPg = new PosgreSql();
$resPg = array();
$resArrectRowPg = array();

//insert1
$setAr = array('key'=>'user15pg','data'=>'testing1pg');
$resInsertPgSql = $objPg->setTableName(TABLE_PG)->insert()->from()->setting($setAr)->setUniqueRecord(array('key'=>'user15pg'))->exec()->getNumberAffectedRecords();

//insert2
$setAr = array('key'=>'user15pg','data'=>'testing2pg');
$resInsertPgSql = $objPg->setTableName(TABLE_PG)->insert()->from()->setting($setAr)->setUniqueRecord(array('key'=>'user15pg'))->exec()->getNumberAffectedRecords();

//select
$resSelectPgSqlAfterInsert = $objPg->setTableName(TABLE_PG)->select(array('key', 'data'))->from()->where("\"key\" = 'user15pg'")->exec()->getAssoc();
if($resSelectPgSqlAfterInsert === false)
    $resArrectRowPg[] = array('mes'=>"ERROR_SELECT", 'flag'=>"fail");
else
{
    $resPg [] = array('operation'=>'insert','result'=>$resSelectPgSqlAfterInsert);
    $resSel = $objPg->getNumberSelectedRecords();
    $resArrectRowPg[] = array('mes'=>"select $resSel record(s)", 'flag'=>'succes');
}

//update
$resUpdatePgSql = $objPg->setTableName(TABLE_PG)->update()->from()->
                        set(array('data'=>'update record'))->
                        where("\"key\" = 'user15pg'")->
                        exec()->getNumberAffectedRecords();
if($resUpdatePgSql > 0)
    $resArrectRowPg[] = array('mes'=>"updated $resUpdatePgSql record(s)", 'flag'=>'succes');
else 
    $resArrectRowPg[] = array('mes'=>"ERROR_UPD", 'flag'=>"fail");

//update
$resUpdatePgSql = $objPg->setTableName(TABLE_PG)->update()->from()->
                        set(array('data'=>'update record pg'))->
                        where("\"key\" = 'user15pg' AND \"data\"='testing1pg'")->
                        exec()->getNumberAffectedRecords();
if($resUpdatePgSql > 0)
    $resArrectRowPg[] = array('mes'=>"updated $resUpdatePgSql record(s)", 'flag'=>'succes');
else 
    $resArrectRowPg[] = array('mes'=>"ERROR_UPD", 'flag'=>"fail");

//select
$resSelectPgSqlAfterUpdate = $objPg->setTableName(TABLE_PG)->select(array('key', 'data'))->from()->where("\"key\" = 'user15pg'")->exec()->getAssoc();
if($resSelectPgSqlAfterUpdate === false)
    $resArrectRowPg[] = array('mes'=>"ERROR_SELECT", 'flag'=>"fail");
else
{
    $resPg [] = array('operation'=>'update','result'=>$resSelectPgSqlAfterUpdate);
    $resSel = $objPg->getNumberSelectedRecords();
    $resArrectRowPg[] = array('mes'=>"select $resSel record(s)", 'flag'=>'succes');
}

//delete
$resDeletePgSql =  $objPg->setTableName(TABLE_PG)->delete()->from()->where("\"key\" = 'user15' AND `data`='update record pg'")->exec()->getNumberAffectedRecords();
if($resDeletePgSql > 0)
     $resArrectRowPg[] = array('mes'=>"deleted $resDeletePgSql record(s)", 'flag'=>'succes');
else 
    $resArrectRowPg[] = array('mes'=>"ERROR_DEL", 'flag'=>"fail");

//selectDelete
$resSelectPgSqlAfterDelete = $objPg->setTableName(TABLE_PG)->select(array('key', 'data'))->from()->where("\"key\" = 'user15pg'")->exec()->getAssoc();
if($resSelectPgSqlAfterDelete === false)
    $resArrectRowPg[] = array('mes'=>"ERROR_SELECT", 'flag'=>"fail");
else
{
    $resPg [] = array('operation'=>'delete','result'=>$resSelectMySqlAfterDelete);
    $resSel = $objPg->getNumberSelectedRecords();
    $resArrectRowPg[] = array('mes'=>"select $resSel record(s)", 'flag'=>'succes');
}





include('templates/index.php');

}
catch(Exception $ex)
{
    echo $ex->getMessage();
}