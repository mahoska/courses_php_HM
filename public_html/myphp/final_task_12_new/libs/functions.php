<?php

function quotation_marks(&$item, $key, $prefix) 
{
    $item = is_string($item)&& strpos($item,'`')===false ?
        "${prefix}${item}${prefix}" : $item;
}


function palceholder(&$item, $key, $prefix) 
{
    $item = "${prefix}${item}" ;
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


function tesingDelete($sbd)
{
    if($sbd==MYSQL)
    {
        $objM = new MyPdo($sbd);
        $objM->delete()->
        from('MY_TEST')->
        where("`key`  LIKE  'user15_t12%'")->
        exec();
    }
    if($sbd==PGSQL)
    {
        $objP = new MyPdo($sbd);
        $objP->delete()->
        from('PG_TEST')->
        where("key LIKE  'user15_t12%'")->
        exec();
    }
}

