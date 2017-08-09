<?php

function quotation_marks(&$item, $key, $prefix) 
{
    
    $item = is_string($item)&& strpos($item,'`')===false ?
        "${prefix}${item}${prefix}" : $item;
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


function tesingSelect()
{
    $obj = new ActiveRecord();
    return $obj->select(array('key', 'data'))->
                from()->
                where("`key` LIKE 'user15_test%'")->
                exec()->
                getAssoc();
    
}

function tesingSelectD()
{
    $obj = new ActiveRecord();
    return $obj->select(array('key', 'data'))->
                from()->
                where("`key` LIKE 'up_user15_test%'")->
                exec()->
                getAssoc();
    
}

function tesingDelete()
{
    $query = "DELETE FROM MY_TEST WHERE `key` LIKE 'user15_test%'";
    $link = DbConnection::getInstance()->getLink(); 
    mysql_query($query, $link);
}

