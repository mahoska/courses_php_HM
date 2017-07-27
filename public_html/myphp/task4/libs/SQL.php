<?php
class Sql
{
    protected $query;
    protected $execQuery;
    protected $fromPart;
    protected $wherePart;
    protected $setPart;
    protected $insertPart;
    protected $ifUpdate;
    protected $ifInsert;
    
    protected $link;

    public function __construct(){
        $this->ifInsert = false;
        $this->ifInsert = false;
    }
    
    public function __destruct() 
    {
        
    }
    
    /*
     * function generates the initial part of the insert query: 
     * SELECT poles 
     * SELECT DISTINCT poles
     * 
     * @param $poles: array, list of selection fields (should not be empty)
     *  
     *  for example:  
     *  for table with string field key,data
     *  ['key', 'data']
     * 
     * @param $distinct: optional bool parameter for sampling without repetition
     * 
     * @return object:  class object
     */
    public function select(array $poles, $distinct = false)
    //public function select(array $poles = [], $distinct = false)
    {
        $this->query = "SELECT ".(($distinct)?"DISTINCT ":"");
        if(count($poles) == 0)
            throw new Exception(FATAL_ERR);
        else
        {
            array_walk($poles, 'quotation_marks', '`');
            $polesStr = implode(", ", $poles);
            $this->query .= $polesStr;
        }
        $this->ifUpdate = false;
        $this->ifInsert = false;

        return $this;
    }
    
    
    /*
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
        array_walk($what, 'quotation_marks', '"');
        $temp = array();
        foreach($what as $key=>$val)
        {
            $tempKey = "`".$key."`";
            $temp[] =  "$tempKey = $val"; 
        }
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
    public function setting(array $poleVal)
    {
        array_walk($poleVal, 'quotation_marks', '"');
        $tempPole = array_keys($poleVal);
        array_walk($tempPole, 'quotation_marks', '`');
        
        $poles = implode(", ", $tempPole);
        $values = implode(", ",array_values($poleVal));
       
        $this->insertPart = "(".$poles.") VALUES (".$values.")";

        return $this;
    }


    /*
     * function forms part of the query indicating which table is working with
     * FROM tableName 
     * 
     * @param $tableName1:  database table with which we work
     * 
     * @return object:  class object
     */
    public function from($tableName)
    {
        $this->fromPart = ($this->ifInsert || $this->ifUpdate) ? $tableName : " FROM $tableName";
        
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
     * "`key` = 'user'"
     * 
     * PS:when writing the terms, make out the name of the fields in quotation marks
     * 
     * @return object:  class object
     */    
    public function where($condition = null)
    {
        if(!is_null($condition))
            $this->wherePart = "WHERE ".$condition;

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
                $this->execQuery .= $this->fromPart." ".$this->insertPart;
            else if($this->ifUpdate)
                $this->execQuery .= $this->fromPart." ".$this->setPart." ".$this->wherePart;
            else
                $this->execQuery .= $this->fromPart." ".$this->wherePart;
          
           
            return $this;
    }

    
}

