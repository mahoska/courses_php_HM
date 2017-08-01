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
    }
    
    public function __destruct()
    {
        pg_close($this->link);
    }
    
    public function exec()
    {
        parent::exec();
        //echo "999".var_dump( $this->execQuery)."9999";
        if(!is_null($this->execQuery))
            $this->result = pg_query( $this->link,$this->execQuery);
        else 
            $this->result = false;
        return $this;
    }
    
    public function select(array $poles, $func = null , $prefix = "")
    {
        $func = 'quotation_marks_pg';
        $prefix = $this->tableName.".";
        return parent::select($poles, $func, $prefix);      
    }
    
    public function setting(array $poleVal, $func = null , $prefix = "")
    {
        $func = 'quotation_marks';
        $prefix = '"';
        return parent::setting($poleVal, $func , $prefix );
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
    
    
    public function setUniqueRecord($what, $func = null , $prefix = "")
    {      
        $func = 'quotation_marks_pg';
        $prefix = $this->tableName.".";
 
        $result =  pg_query($this->link, parent::setUniqueRecord($what,$func,$prefix));
        
        $ifUniqQuery = pg_num_rows($result);
        
        if ($ifUniqQuery>0) 
           $this->ifExec = true;
        else
            $this->ifExec = false;
        
        return $this;
    }
     
     public function setTableName($tableName)
   {
       $this->tableName = "\"public\"."."\"$tableName\"";
       return $this;
   }
   
    protected  function ecranKey($what)
    {
        $temp = array();
        foreach($what as $key=>$val)
        {
            $tempKey = $this->tableName.".\"$key\"";
            $temp[] =  "$tempKey = $val"; 
        }
        
        return $temp;
    }
    
    protected  function ecranKeySet($what)
    {
        $temp = array();
        foreach($what as $key=>$val)
        {
            $tempKey = "\"$key\"";
            $temp[] =  "$tempKey = $val"; 
        }
        
        return $temp;
    }
}