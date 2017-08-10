<?php

class MyPdo extends Sql
{  
    private $pdo;
    private $sth;
    private $result;

    public function __construct($sbd)
    {
        parent::__construct();
        $this->sbd = $sbd;
        
         if( $this->sbd == MYSQL)
        {
            $this->pdo = new PDO('mysql:host='.HOST.';dbname='.DBNAME, USER, PSW);  
        }
        else if( $this->sbd == PGSQL)
        {
            $this->pdo = new PDO('pgsql:host='.PGHOST.';port=5432;dbname='.PGDBNAME.';user='. PGUSER.';password='. PGPSW);  
        }
        
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    }

    public function __destruct()
    {
        $this->pdo = null;
    }
    
    public function exec()
    {
        parent::exec();
        
        //echo $this->execQuery;
        if(!is_null($this->execQuery))
        {
            if(empty($this->data))
            {
                $this->sth = $this->pdo->query($this->execQuery);
                $this->result = true;
            }
            else
            {
            $this->sth = $this->pdo->prepare($this->execQuery);
          
            $this->sth->execute($this->data);
            $this->result = true;
            }
            
        }
        else 
            $this->result = false;
        
        $this->data = [];
        return $this;
    }
    

    public function getAssoc()
    {
       if( $this->result)
       {
            $this->sth->setFetchMode(PDO::FETCH_ASSOC);
            $this->result = [];
            while($row = $this->sth->fetch())
            { 
                 $this->result[] = $row;
            }
       }
       
       return $this->result;
    }


    public function setUniqueRecord($what)
    {
        //echo parent::setUniqueRecord($what);
        $sth = $this->pdo->prepare(parent::setUniqueRecord($what));
        $sth->execute($what);
        $sth->setFetchMode(PDO::FETCH_NUM);
        $res = $sth->fetch();

        if ($res[0]>0) 
           $this->ifExec = true;
        else
            $this->ifExec = false;

        return $this;
    }

}

