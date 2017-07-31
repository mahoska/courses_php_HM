<?php


class MySql extends Sql
{
    
    private $result;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->link = mysql_connect(HOST, USER, PSW); 
        if (!$this->link) 
            throw new Exception(ERROR_CONNECT . mysql_error());
        
        $ifDb = mysql_select_db(DATABASE);
        if (!$ifDb)
            throw new Exception(ERROR_DB);  
    }
    
    public function __destruct()
    {
        mysql_close($this->link);
    }
    
    public function select(array $poles,  $func = null , $prefix = null)
    {
        $func = 'quotation_marks';
        $prefix = "`";
        return parent::select($poles, $func, $prefix);      
    }
    
    public function setting(array $poleVal, $func = null , $prefix = "")
    {
        $func = 'quotation_marks';
        $prefix = "`";
        return parent::setting($poleVal, $func , $prefix );
    }
    
    
    public function exec()
    {
        parent::exec();
        
        if(!is_null($this->execQuery))
            $this->result = mysql_query($this->execQuery, $this->link);
        else 
            $this->result = false;
        return $this;
    }
    
    /*
     * function of obtaining an associative array by the result of the operation of the query
     *works  with SELECT
     * 
     * @return array/false: numbered array - result selection or  false in case of error
     */
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
    
    /*
     * function of obtaining an associative array by the result of the operation of the query
     * if the result of the query is one record
     * works  with SELECT
     * 
     * @return array/false: numbered array - result selection or  false in case of error
     */
    public function getOneAssoc()
    {
        if($this->result)
            return mysql_fetch_assoc($this->result);	
        else 
            return $this->result; 
    }
    
    /*
     * function is used if the result of the sample is one value
     * puts it in a numbered array - in its zero element
     * works  with SELECT
     * 
     * @return array/false: numbered array - result selection or  false in case of error
     */
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
    
    /*
     * function to get the number of rows returned by the SELECT query
     * works  with SELECT
     * 
     * @return int: number of selected rows 
     */
    public function getNumberSelectedRecords()
    {
        return  mysql_num_rows($this->result);	
    }
    
    /*function to get the number of rows returned by the modify query
     * Works  with queries that modify the table (DELETE, UPDATE, INSERT)
     * 
     * @return int: number of affected rows 
     */
    public function getNumberAffectedRecords()
    {
        return mysql_affected_rows();	 
    }
    
    public function setUniqueRecord($what, $func = null , $prefix = "")
    {
         $func = 'quotation_marks';
        $prefix = "`";
        $result =  mysql_query(parent::setUniqueRecord($what,$func,$prefix),$this->link);
        $ifUniqQuery = mysql_num_rows($result);

        if ($ifUniqQuery>0) 
           $this->ifExec = true;
        else
            $this->ifExec = false;
        
        return $this;
    }
    
    protected  function ecranKey($what)
    {
        $temp = array();
        foreach($what as $key=>$val)
        {
            $tempKey = "`".$key."`";
            $temp[] =  "$tempKey = $val"; 
        }
        
        return $temp;
    }
     
    protected  function ecranKeySet($what)
    {
       return $this->ecranKey($what);
    }    
}