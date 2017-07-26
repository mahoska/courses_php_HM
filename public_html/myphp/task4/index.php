<?php

include('config.php');
include('libs/SQL.php');

$obj = new SQL();
echo $obj->select([key, data])->from('MY_TEST')->where("key = 'user'")->exec(),"<br>";

echo $obj->delete()->from('MY_TEST')->where("key = 'user'")->exec(),"<br>";

$setAr = ['key'=>'user15','data'=>'testing'];
echo $obj->insert()->from('MY_TEST')->setting($setAr);



