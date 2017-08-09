<?php

class DbConnection
{
    private $pdo;
    private static $instance;
    
    private function __construct($sbd)
    {
        if($sbd == MYSQL)
        {
            $this->pdo = new PDO('mysql:host='.HOST.';dbname='.DBNAME, USER, PSW);  
        }
        else if($sbd == PGSQL)
        {
            $this->pdo = new PDO('mysql:host='.PGHOST.';dbname='.PGDBNAME, PGUSER, PGPSW);  
        }
        
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    
    private function __clone(){}
    
    public function getLink()
    {
        return $this->pdo;
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

