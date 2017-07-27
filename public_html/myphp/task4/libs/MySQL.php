<?php

class MySql extends Sql
{

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
    
    /*
     * function of obtaining an associative array by the result of the operation of the query
     *works  with SELECT
     * 
     * @return array/false: numbered array - result selection or  false in case of error
     */
     function getAssoc()
    {
        $result = mysql_query($this->execQuery, $this->link);
        if($result) 
        {
            $selection=array();
            while ($item = mysql_fetch_assoc($result))
                $selection[] = $item;
            
            return $selection;
        }
        return $result;
    }
    
    /*
     * function of obtaining an associative array by the result of the operation of the query
     * if the result of the query is one record
     * works  with SELECT
     * 
     * @return array/false: numbered array - result selection or  false in case of error
     */
    function getOneAssoc()
    {
        $result = mysql_query($this->execQuery,$this->link);
        if($result)
            return mysql_fetch_assoc($result);	
        else 
            return $result; 
    }
    
    /*
     * function is used if the result of the sample is one value
     * puts it in a numbered array - in its zero element
     * works  with SELECT
     * 
     * @return array/false: numbered array - result selection or  false in case of error
     */
    function getOneRow()
    {
        $result = mysql_query($this->execQuery,$this->link);
        if($result)
            return mysql_fetch_row($result);	
        else 
            return $result; 
    }
    
    /*
     * function to get the number of rows returned by the SELECT query
     * works  with SELECT
     * 
     * @return int: number of selected rows 
     */
    function getNumberSelectedRecords()
    {
        $result = mysql_query($this->execQuery,$this->link);
        return  mysql_num_rows($result);	
    }
    
    /*function to get the number of rows returned by the modify query
     * Works  with queries that modify the table (DELETE, UPDATE, INSERT)
     * 
     * @return int: number of affected rows 
     */
    function getNumberAffectedRecords()
    {
        $result = mysql_query($this->execQuery,$this->link);
        return mysql_affected_rows();	 
    }
        
}