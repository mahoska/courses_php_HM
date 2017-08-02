<?php

class SessionData implements iData
{ 
    public  static function start()
    {
        session_start();
    } 

    public static function destroy()
    {
        session_destroy();
    }

    public  function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public function setData($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function readData($key)
    {
        if($this->has($key))
            return $_SESSION[$key];
        
        return SESSION_DEFAULT;

    }

    public function deleteData($key)
    {
        if($this->has($key))
            unset($_SESSION[$key]);
    }
}
