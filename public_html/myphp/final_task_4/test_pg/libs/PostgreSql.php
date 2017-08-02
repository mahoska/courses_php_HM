<?php 
class PosgreSql extends Sql
{
    private $result;
    
     public function __construct() 
    {
        parent::__construct();
        
        $this->link = pg_connect("host=".HOSTPG." port=5432 dbname=".DATABASEPG." user=".USERPG." password=".PSWPG);
       
        if (!$this->link) 
            throw new Exception(ERROR_CONNECT); 
        
        $this->sbd = PGSQL;
    }
    
    public function __destruct()
    {
        pg_close($this->link);
    }
    
    public function exec()
    {
        parent::exec();
        //echo  $this->execQuery."<br><br>";
        if(!is_null($this->execQuery))
            $this->result = pg_query( $this->link,$this->execQuery);
        else 
            $this->result = false;
        return $this;
    }
    
    public function getAssoc()
    {
        if($this->result) 
        {
            $selection=array();
            while ($row = pg_fetch_array($this->result, null, PGSQL_ASSOC)) {
                $selection[] = $row;
            }
            return $selection;
        }
        
        //pg_free_result($this->result);
        
        return $this->result;
    }
    
    public function getOneAssoc()
    {
        if($this->result)
            return pg_fetch_array($this->result, null, PGSQL_ASSOC);	
        else 
            return $this->result; 
    }
    
    public function getOneRow()
    {
        if($this->result)
        {
            $selection = pg_fetch_row($this->result, 0);
            return $selection[0];
        }
        else 
            return $this->result; 
    }
    
    public function getNumberSelectedRecords()
    {
        return  pg_num_rows($this->result);	
    }
    
    public function getNumberAffectedRecords()
    {
        return pg_affected_rows($this->result);	 
    }
    
    
    public function setUniqueRecord($what)
    {   
        $result =  pg_query($this->link, parent::setUniqueRecord($what));
        
        $ifUniqQuery = pg_num_rows($result);
        
        if ($ifUniqQuery>0) 
           $this->ifExec = true;
        else
            $this->ifExec = false;
        
        return $this;
    }
     
  
  
}