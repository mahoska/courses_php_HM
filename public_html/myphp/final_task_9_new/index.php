<?php

include('libs/HtmlHelper.php');

$head = ['name','age'];
$data = array(
    ['name'=>'Rita', 'age'=>7],
    ['name'=>'Sasha', 'age'=>14]
);
$table1 = HtmlHelper::createTable($head,$data,'myTClass', HtmlHelper::CENTER, 'Children');
$table2 = HtmlHelper::createTable($head,$data,null, HtmlHelper::RIGHT, null, false, false, true, false,true);

$dataList = ['apple','orange','banana'];
$list1 = HtmlHelper::createList($head, false, false, 'myLClass');
$list2 = HtmlHelper::createList($head);


$dataDList =['HTML'=>'Hyper Text Markup Language','CSS'=>'Cascade Style Sheet'];
$dlist1 = HtmlHelper::createDList($dataDList);
$dlist2 = HtmlHelper::createDList($dataDList,'myDlist');

$dataSel = array('null'=>'выберите сферу деятельности','education'=>'образование','medicine'=>'медицина',
    'politics'=>'политика','service_sector'=>'сфера обслуживания',
    'sport'=>'спорт' );
$select1 = HtmlHelper::createSelectMulty($dataSel, 'sector', 0, [0,3], 'sectorList','classSel' );
$select2= HtmlHelper::createSelectMulty($dataSel, 'sector', 4, [0], 'sectorList', 'classSel' , true, 5 );

$dataCheck = array('education'=>'образование','medicine'=>'медицина',
    'politics'=>'политика','service_sector'=>'сфера обслуживания',
    'sport'=>'спорт' );
$checkboxes = HtmlHelper::createCheckBox($dataCheck,'checkList', [1,3], [0]);

$radioButtonGroup = HtmlHelper::createRadioGroup($dataCheck,'radioList',2, [1,3]);


include('templates/index.php');
