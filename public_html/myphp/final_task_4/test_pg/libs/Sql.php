<?php
abstract class Sql
{
      
    protected $query;
    protected $execQuery;
    protected $fromPart;
    protected $wherePart;
    protected $setPart;
    protected $insertPart;
    protected $ifUpdate;
    protected $ifInsert;
    protected $isUniqueRecord;
    protected $ifExec;
    protected $tableName;

    protected $link;
    protected $sbd;

    public function __construct(){
        $this->ifInsert = false;
        $this->ifInsert = false;
        $this->isUniqueRecord = false;
        $this->ifExec = false;
    }
    
    public abstract function __destruct(); 
    
    /*
     * function generates the initial part of the insert query: 
     * SELECT poles 
     *
     * 
     * @param $poles: array, list of selection fields (should not be empty)
     * 
     *  for example:  
     *  for table with string field key,data
     *  ['key', 'data']
     * 
     * 
     * @return object:  class object
     */
    public function select(array $poles)
    {
        $this->query = "SELECT ";
        if(count($poles) == 0)
            throw new Exception(FATAL_ERR);
        else
        {
            if($this->sbd == MYSQL)
                 array_walk($poles, 'quotation_marks' , "`");
            if($this->sbd == PGSQL)
                 array_walk($poles, 'quotation_marks_pg' , $this->tableName.".");
            $polesStr = implode(", ", $poles);
            $this->query .= $polesStr;
        }
        $this->ifUpdate = false;
        $this->ifInsert = false;

        return $this;
    }
    
    
    /*$func , $prefix
     * function generates the initial part of the delete request:
     * DELETE 
     * 
     * @return object:  class object
     */
    public function delete()
    {
        $this->query = "DELETE";
        $this->ifUpdate = false;
        $this->ifInsert = false;

        return $this;
    }

     /*
     * function generates the initial part of the update request:
     * UPDATE 
     * 
     * @return object:  class object
     */
    public  function update()
    {
        $this->query = "UPDATE";
        $this->ifUpdate = true;
        $this->ifInsert = false;

        return $this;
    }

    /*
     * function continues to form the initial part of the update request, forming a piece
     * SET pole1=value1, pole2=value2...
     * 
     * @param $what: associative array['key'=>val,...], where
     *  'key' - name table field which is subject to change
     *  'val' - established field value
     * 
     *  for example:  
     *  for table with string field key,data
     *  ['key'=>'user15','data'=>'testing'];
     * 
     * @return object:  class object
     */
     public function set(array $what)
    {
        $this->setPart = "SET";

        array_walk($what, 'quotation_marks', "'");
        $temp = $this->ecranKey($what);
        
        $this->setPart .= " ".implode(", ",$temp);

        return $this;
    }
    
     /*
     * function generates the initial part of the insert request:
     * INSERT 
     * 
     * @return object:  class object
     */
    public function insert()
    {
        $this->query = "INSERT INTO";
        $this->ifUpdate = false;
        $this->ifInsert = true;

        return $this;
    }

    /*
     * function continues to form the initial part of the insert request, forming a piece
     * (pole1, pole2,...) VALUES (val1, val2,...)
     * 
     * @param $poleVal: associative array['key'=>val,...], where
     *  'key' - name table field
     *  'val' - field value 
     * 
     *  for example:  
     *  for table with string field key,data
     *  ['key'=>'user15','data'=>'testing'];
     * 
     * @return object:  class object
     */
    public function setting(array $poleVal, $func = null , $prefix = "")
    {
        array_walk($poleVal, 'quotation_marks', "'");
        
        $tempPole = array_keys($poleVal);
            if($this->sbd == MYSQL)
                array_walk($tempPole, 'quotation_marks' , "`");
            if($this->sbd == PGSQL)
                array_walk($tempPole, 'quotation_marks' , '"');
        
        $poles = implode(", ", $tempPole);
        $values = implode(", ",array_values($poleVal));
       
        $this->insertPart = "(".$poles.") VALUES (".$values.")";

        return $this;
    }


    /*
     * function forms part of the query indicating which table is working with
     * FROM tableName 
     * 
     * @return object:  class object
     */
    public function from()
    {
        $this->fromPart = ($this->ifInsert || $this->ifUpdate) ? $this->tableName : " FROM $this->tableName";
        return $this;
    }
    
    
    /*
     * function generates the conditional part of the query
     * WHERE condition
     * 
     * param $condition: string representing condition
     * 
     * for example: 
     * for table with string field key
     * "`key` = 'user'" - for mysql
     * "\"key\" = 'user15pg'" -for postgresql
     * 
     * PS:when writing the terms, make out the name of the fields in quotation marks
     * 
     * @return object:  class object
     */    
    public function where($condition = null)
    {
        if(!is_null($condition))
            $this->wherePart = "WHERE ".$condition;
        else 
        {
            if(!$this->ifInsert)
                $this->wherePart = "WHERE 1";
        }
        return $this;
    }
    
    /*
     * function that collects a query from components
     * 
     * @return object:  class object
     */
    public function exec()
    {
            $this->execQuery = $this->query." ";
            
            if($this->ifInsert)
            {
                if($this->isUniqueRecord)
                { 
                    if($this->ifExec)
                        $this->execQuery = null;
                    else 
                        $this->execQuery .= $this->fromPart." ".$this->insertPart; 
                }
                else
                    $this->execQuery .= $this->fromPart." ".$this->insertPart; 
            }
             
            else if($this->ifUpdate)
                $this->execQuery .= $this->fromPart." ".$this->setPart." ".$this->wherePart;
            else
                $this->execQuery .= $this->fromPart." ".$this->wherePart;
            
            return $this;
    }
    
    /*
     * function assigns a unique field (combination of fields) and
     *  generates a request for checking the presence 
     * of the transmitted combination in the table
     * /In the child classes the verification question is started and 
     * the property is determined - it is possible to do 
     * the insertion of the record into the table/
     * 
     * @param $what: associative array['key'=>val,...], where
     *  'key' - name table field
     *  'val' - field value 
     * 
     * for example:  
     * for table with string field key
     * ['key'=>'user15'];
     * 
     * @return string:  request for a sample
     */
   public function setUniqueRecord($what)
   {
        $this->isUniqueRecord = true;
        
        $poles = array_keys($what);
        
        if($this->sbd == MYSQL)
                 array_walk($poles, 'quotation_marks' , "`");
            if($this->sbd == PGSQL)
                 array_walk($poles, 'quotation_marks_pg' , $this->tableName.".");
        $polesStr = implode(", ", $poles);
        
        array_walk($what, 'quotation_marks', "'");
        
        $temp = $this->ecranKey($what);
        $strCond = implode(" AND ",$temp);
        //echo "SELECT $polesStr FROM $this->tableName WHERE $strCond<br>";
        return "SELECT $polesStr FROM $this->tableName WHERE $strCond";
       
   }
   
   /*
    * Assigns the name of the worksheet
    * 
    * @return object:  class object
    */
   public function setTableName($tableName)
   {
       $this->tableName = $tableName;
       return $this;
   }

   /*
    * auxiliary methods
    */
    protected  function ecranKey($what)
    {
        $temp = array();
        foreach($what as $key=>$val)
        {
            if($this->sbd == MYSQL)
                $tempKey = "`".$key."`";
            if($this->sbd == PGSQL)
                $tempKey = "\"$key\"";
            $temp[] =  "$tempKey = $val"; 
        }
        
        return $temp;
    }
}

