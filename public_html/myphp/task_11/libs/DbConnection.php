<?php

class DbConnection
{
    private $link;
    private static $instance;
    
    private function __construct()
    {
        @$this->link = mysql_connect(HOST, USER, PSW);
        //$this->link = mysqli_connect(HOST, USER, PSW);
        if (!$this->link) 
            throw new Exception(ERROR_CONNECT . mysql_error($this->link));
            //throw new Exception(ERROR_CONNECT . mysqli_error($this->link));
        
        $ifDb = mysql_select_db(DBNAME);
        //$ifDb = mysqli_select_db($this->link,DATABASE);
        if (!$ifDb)
            throw new Exception(ERROR_DB);  
    }
    
    private function __clone(){}
    
    public function getLink()
    {
        return $this->link;
    }
    
    public function __wakeUp()
    {
        throw new Exception();
    }
    
    public static  function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new DbConnection();
        }
        return self::$instance;
    }
}

