<?php

include('config.php');
include('libs/functions.php');
include('libs/MySql.php');

$obj = new MySql();
$obj->setTableName('MY_TEST');
$obj->setData('user15','task 5 testing insert','`key`','`data');
/*
$resSelect = $obj->readData('user15',`key`);
var_dump($resSelect);
 */
