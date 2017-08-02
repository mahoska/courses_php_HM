<?php

class DbConnection
{
    private $link;
    private static $instance;
    
    private function __construct($sbd)
    {
        if($sbd == MYSQL)
        {
            $this->link = new PDO("mysql: host=".HOST."; dbname=".DBNAME, USER, PSW);
            $this->link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->link->exec("SET NAMES utf8");
        }
        else if($sbd == PGSQL)
        {
            $this->link = pg_connect("host=".HOSTPG." port=5432 dbname=".DATABASEPG." user=".USERPG." password=".PSWPG);
            if (!$this->link) 
                throw new Exception(ERROR_CONNECT); 
        }
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
    
    public static  function getInstance($sbd)
    {
        if(self::$instance == null){
            self::$instance = new DbConnection($sbd);
        }
        return self::$instance;
    }
}

