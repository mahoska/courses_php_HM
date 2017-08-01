<?php

class CookieData implements iData
{
    
    public function setData($key, $value)
    {
        setcookie($key, $value, time() + COOKIEE_TIME, '/') ;
    }
    
    
    public  function readData($key)
    {
        if ( isset($_COOKIE[$key]) ){
            return $_COOKIE[$key];
        }
        
        return null;
    }
    
    public  function deleteData($key)
    {
        if (isset($_COOKIE[$key])){
            self::set($key, 'x', 1);
            unset($_COOKIE[$key]);
        }
    }
}