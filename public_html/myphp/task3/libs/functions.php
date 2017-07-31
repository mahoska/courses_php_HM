<?php

function getFileLines($fileName)
{
    $obj = new FileReader($fileName);
     $fileArrLine = [];
    $i = 0;
    while(($line = $obj->readByLine($i)) !== false)
    {
        $fileArrLine[$i++] = $line;
    }
    return $fileArrLine;
}

function getFileChares($fileName)
{
    $obj = new FileReader($fileName);
    $fileArrChars = [];
    $i = 0;
    $j = 0;
    while(($symb  = $obj->readByChar($i, $j)) !== false) 
    {
        while(($symb  = $obj->readByChar($i, $j)) !== false) 
        {
            $fileArrChars[$i][$j++] = $symb;
        }
        $j = 0;
        $i++;
    }
    return $fileArrChars;
}

function setFlash($message,$default='success')
{
    $_SESSION[FLASH_KEY] = array('status' => $default, 'message' => $message);
}

function getFlash()
{
    if (!isset($_SESSION[FLASH_KEY])) {
        return null;
    }
    
    $flash = $_SESSION[FLASH_KEY];
    unset($_SESSION[FLASH_KEY]);
    
    return $flash;
}