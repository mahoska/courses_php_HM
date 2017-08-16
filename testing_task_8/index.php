<?php
include('libs/functions.php');
include('libs/Curl.php');

$result = "";

    $search = requestPost('search');
    //$search = checkForm($search);
    $url  = 'http://www.google.com.ua/search?q=' .$search;
    
    $curl = new Curl($url);
    $curl->setPage($search);
    $curl->getEditedPage();
    
    
    


include("templetes/index.php");
?>
