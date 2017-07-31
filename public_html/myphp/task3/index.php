<!DOCTYPE html>
<!--
Task#3
Создать класс:

а) Чтения файла, чтобы были метод построчного доступа(чтение) к данным и метод посимвольного доступа(чтение) к данным,
распечатать все это вне класса.

б) Добавить метод в этот класс который сможет заменять всю строку, и метод заменяющий любой символ в строке, 
метод сохраняющий изменения. 
Распечатать новое содержимое способом а)

-->
<?php
include('config.php');
include('libs/FileReader.php');
include('libs/functions.php');


try {

    //*****************testing part a****************************
    //get File as Array of Line
    $fileArrLine =  getFileLines("files/test.txt");
    
    //get File as Array of Chars
    $fileArrChars = getFileChares("files/test.txt");
   
    //empty file
    $fileArrLineEmp =  getFileLines("files/empty.txt");
    $fileArrCharsEmp = getFileChares("files/empty.txt");
    
    $resL = array(
        ["fileName"=>"test.txt", "result"=>$fileArrLine],
        ["fileName"=>"empty.txt", "result"=>$fileArrLineEmp],
       
   );
    $resS = array(
        ["fileName"=>"test.txt", "result"=>$fileArrChars], 
        ["fileName"=>"empty.txt", "result"=>$fileArrCharsEmp]
    );
  // var_dump($res);
//*****************testing part b****************************
    
$beforRepl = getFileLines("files/test_repl.txt");

$obj = new FileReader("files/test_repl.txt");
$resReplLine = $obj->replaceLine(3, "***some testing string***");
$obj->writeFile();
$resReplChar = $obj->replaceChar(5, 2, "*");

$obj->writeFile();
$afterRepl = getFileLines("files/test_repl.txt");

$resRepl = array(
    ["fileName"=>"test_repl.txt", "result"=>$beforRepl, "key"=>"before"],
    ["fileName"=>"test_repl.txt", "result"=>$afterRepl,"key"=>"after"]
);

} catch (Exception $ex) {
    setFlash($ex->getMessage(),'fail');
}

$flashMessage = getFlash();   
include("templates/index.php");