<?php
include('config.php');
include('libs/Calculate.php');

$a = 10;
$b = 15;
//testing standart operation
$obj1 = new Calculate($a, $b);
$data = ['a'=>$obj1->getNumber1(),'b'=>$obj1->getNumber2()];
$res1 = array (
                ['res'=>$obj1->plus(), 'operation'=>'+', 'data'=>$data],
                ['res'=>$obj1->minus(), 'operation'=>'-', 'data'=>$data],
                ['res'=>$obj1->devide(), 'operation'=>'/', 'data'=>$data],
                ['res'=>$obj1->multy(), 'operation'=>'*', 'data'=>$data],
                ['res'=>$obj1->procent(), 'operation'=>'%', 'data'=>$data],
                ['res'=>$obj1->radical(),'operation'=>'sqrt', 'data'=>$data],
            );
$obj1->setNumber2(0);
$resDivByZero = $obj1->devide();
$data = ['a'=>$obj1->getNumber1(),'b'=>$obj1->getNumber2()];
$res1[] =  ['res'=>$resDivByZero,'operation'=>'/', 'data'=>$data];

$a = -81;
$obj1->setNumber1($a);
$negativRadic = $obj1->radical();
$data = ['a'=>$obj1->getNumber1(),'b'=>$obj1->getNumber2()];
$res1[] =  ['res'=>$negativRadic,'operation'=>'sqrt', 'data'=>$data];

//testing oparation with memory
$operationWithMemory = [];

//256 MS MR * 12  => 3840
$numB = 256;
Calculate::memorySave($numB);//256
$obj1->setNumber1(Calculate::memoryReturn());//256
$b = 15;
$obj1->setNumber2($b);
$res2 = $obj1->multy();//256*15=3840
$operationWithMemory[] = ['res'=>$res2,'operation'=>'256 MS MR * 15'];

//(10/2)= MS 5 M+ (4- MR) /3   => -2
$c = 10;
$d = 2;
$numB = 5;
$obj2 = new Calculate($c, $d);
$temp = $obj2->devide();//5
Calculate::memorySave($temp);//m 5
Calculate::memoryPlus($numB);//m 10
$a = 4;
$obj2->setNumber1($a);
$obj2->setNumber2(Calculate::memoryReturn());//10
$obj2->setNumber1($obj2->minus());//4 - 10 = -6
$b = 3;
$obj2->setNumber2($b);
$res3 = $obj2->devide();//-2
$operationWithMemory[] = ['res'=>$res3,'operation'=>'(10/2)= MS 5 M+ (4- MR) /3'];


//sqrt(81)  MS 9+ MR = M+  MR => 27
//continue 
//MC 5 M- MR  => -5
$a = 81;
$obj3 = new Calculate($a);
Calculate::memorySave($obj3->radical());
$a = 9;
$obj3->setNumber1($a);
$obj3->setNumber2(Calculate::memoryReturn());
$temp = $obj3->plus();
Calculate::memoryPlus($temp);
$res4 = Calculate::memoryReturn();
$operationWithMemory[] = ['res'=>$res4,'operation'=>'sqrt(81)  MS 9+ MR = M+  MR'];
//continue
Calculate::memoryClear();
$numB = 5;
Calculate::memoryMinus($numB);
$res5 = Calculate::memoryReturn();
$operationWithMemory[] = ['res'=>$res5,'operation'=>'MC 5 M- MR  => -5'];


include('templates/index.php');
