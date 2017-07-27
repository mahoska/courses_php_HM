<?php

function quotation_marks(&$item, $key, $prefix) 
{
    $item = is_string($item) ? "${prefix}${item}${prefix}" : $item;
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
