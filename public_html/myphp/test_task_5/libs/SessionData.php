<?php

class SessionData implements iData
{ 
    public  static function start()
    {
        session_start();
    } 

    public function destroy()
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

    public function readData()
    {
        if($this->has($key))
            return $_SESSION[$key];
        
        return SESSION_DEFAULT;

    }

    public function deleteData()
    {
        if($this->has())
            unset($_SESSION[$key]);
    }
}
