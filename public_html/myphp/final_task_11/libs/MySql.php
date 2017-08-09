<?php

class MySql extends Sql
{
    
    protected $result;
    
    public  function __construct()
    {
        parent::__construct();
        $this->link = DbConnection::getInstance()->getLink(); 
        $this->sbd = MYSQL;
    }
    
    public function __destruct(){}
      
    public function exec()
    {
        parent::exec();

        if(!is_null($this->execQuery))
            $this->result = mysql_query($this->execQuery, $this->link);
        else 
            $this->result = false;
        
        return $this;
    }
    
     public function getAssoc()
    {
        if($this->result) 
        {
            $selection=array();
            while ($item = mysql_fetch_assoc($this->result))        
                $selection[] = $item;
            
            return $selection;
        }
        return $this->result;
    }
    
    public function getOneAssoc()
    {
         if($this->result)
            return mysql_fetch_assoc($this->result);		
        else 
            return $this->result; 
    }
    
    public function getOneRow()
    {
        if($this->result)
        {
            $selection = mysql_fetch_row($this->result);
            return $selection[0];
        }
        else 
            return $this->result; 
    }
    
    public function getNumberSelectedRecords()
    {	
         return  mysql_num_rows($this->result);	
    }
    
    public function getNumberAffectedRecords()
    {
         return mysql_affected_rows($this->result);
    }
    
    public function setUniqueRecord($what)
    {
        $result = mysql_query(parent::setUniqueRecord($what),$this->link);
       
        $ifUniqQuery = mysql_num_rows($result);

        if ($ifUniqQuery>0) 
           $this->ifExec = true;
        else
            $this->ifExec = false;
        
        return $this;
    }
    
}
