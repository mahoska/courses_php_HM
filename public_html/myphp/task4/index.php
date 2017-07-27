<?php
include('config.php');
include('libs/functions.php');
include('libs/Sql.php');
include('libs/MySql.php');

session_start();

//$obj = new Sql();
//echo $obj->select(['key', 'data'])->from('MY_TEST')->where("`key` = 'user'")->exec(),"<br>";
//
//echo $obj->select(['key', 'data'], true)->from('MY_TEST')->where("`key` = 'user'")->exec(),"<br>";
//
//echo $obj->delete()->from('MY_TEST')->where("`key` = 'user'")->exec(),"<br>";
//
//$setAr = ['key'=>'user15','data'=>'testing'];
//echo $obj->insert()->from('MY_TEST')->setting($setAr)->exec(),"<br>";
//
//echo $obj->update()->from('MY_TEST')->set(['key'=>'user15', 'data'=>'testing'])->exec();

//obj = new Sql();
$obj = new MySql();
$res = array();
$resArrectRow = array();

//insert1
$setAr = array('key'=>'user15','data'=>'testing1');
$resInsertMySql = $obj->insert()->from('MY_TEST')->setting($setAr)->exec()->getNumberAffectedRecords();
if($resInsertMySql > 0)
    $resArrectRow[] = array('mes'=>"added $resInsertMySql record(s)", 'flag'=>'succes');
else 
    $resArrectRow[] = array('mes'=>"ERROR_INS",'flag'=>"fail");

//insert2
$setAr = array('key'=>'user15','data'=>'testing2');
$resInsertMySql = $obj->insert()->from('MY_TEST')->setting($setAr)->exec()->getNumberAffectedRecords();
if($resInsertMySql > 0)
     $resArrectRow[] = array('mes'=>"added $resInsertMySql record(s)", 'flag'=>'succes');
else 
    $resArrectRow[] = array('mes'=>"ERROR_INS", 'flag'=>"fail");

//select
$resSelectMySqlAfterInsert = $obj->select(array('key', 'data'))->from('MY_TEST')->where("`key` = 'user15'")->exec()->getAssoc();
if($resSelectMySql === false)
    $resArrectRow[] = array('mes'=>"ERROR_SELECT", 'flag'=>"fail");
else
{
    $res [] = array('operation'=>'insert','result'=>$resSelectMySqlAfterInsert);
    $resSel = $obj->getNumberSelectedRecords();
    $resArrectRow[] = array('mes'=>"select $resSel record(s)", 'flag'=>'succes');
}

//update
$resUpdateMySql = $obj->update()->from('MY_TEST')->
                        set(array('data'=>'update record'))->
                        where("`key` = 'user15' AND `data`='testing2'")->
                        exec()->getNumberAffectedRecords();
if($resUpdateMySql > 0)
    $resArrectRow[] = array('mes'=>"updated $resUpdateMySql record(s)", 'flag'=>'succes');
else 
    $resArrectRow[] = array('mes'=>"ERROR_UPD", 'flag'=>"fail");

//select
$resSelectMySqlAfterUpdate = $obj->select(array('key', 'data'))->from('MY_TEST')->where("`key` = 'user15'")->exec()->getAssoc();
if($resSelectMySql === false)
    $resArrectRow[] = array('mes'=>"ERROR_SELECT", 'flag'=>"fail");
else
{
    $res [] = array('operation'=>'update','result'=>$resSelectMySqlAfterUpdate);
    $resSel = $obj->getNumberSelectedRecords();
    $resArrectRow[] = array('mes'=>"select $resSel record(s)", 'flag'=>'succes');
}

//delete
$resDeleteMySql =  $obj->delete()->from('MY_TEST')->where("`key` = 'user15' AND `data`='testing1'")->exec()->getNumberAffectedRecords();
if($resDeleteMySql > 0)
     $resArrectRow[] = array('mes'=>"deleted $resDeleteMySql record(s)", 'flag'=>'succes');
else 
    $resArrectRow[] = array('mes'=>"ERROR_DEL", 'flag'=>"fail");

//selectDelete
$resSelectMySqlAfterDelete = $obj->select(array('key', 'data'))->from('MY_TEST')->where("`key` = 'user15'")->exec()->getAssoc();
if($resSelectMySql === false)
    $resArrectRow[] = array('mes'=>"ERROR_SELECT", 'flag'=>"fail");
else
{
    $res [] = array('operation'=>'delete','result'=>$resSelectMySqlAfterDelete);
    $resSel = $obj->getNumberSelectedRecords();
    $resArrectRow[] = array('mes'=>"select $resSel record(s)", 'flag'=>'succes');
}



$flashMessage = getFlash();

include('templates/index.php');