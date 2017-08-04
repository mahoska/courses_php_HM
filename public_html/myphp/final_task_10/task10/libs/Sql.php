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
    protected $ifSelect;
    protected $isUniqueRecord;
    protected $ifExec;
    protected $tableName;

    protected $link;
    protected $sbd;


    protected $joinPart;
    protected $leftJoinPart;
    protected $rightJoinPart;
    protected $crossJoinPart;
    protected $naturalJoinPart;
    protected $limitPart;
    protected $orderPart;
    protected $havingPart;
    protected $groupPart;



    public function __construct($sbd){
        $this->ifInsert = false;
        $this->ifUpdate = false;
        $this->ifSelect = false;
        $this->isUniqueRecord = false;
        $this->ifExec = false;
        $this->joinPart = false;
        $this->leftJoinPart = false;
        $this->rightJoinPart = false;
        $this->crossJoinPart = false;
        $this->naturalJoinPart = false;
        $this->orderPart = false;
        $this->groupPart = false;
        $this->havingPart = false;
        $this->orderPart = false;
        
        $this->sbd = $sbd;

    }
    
    public  function __destruct(){}
    
    /*
     * function generates the initial part of the insert query: 
     * SELECT poles 
     *
     * 
     * @param $poles: array, list of selection fields (should not be empty)
     * @param $distinct: bool(true - if you want to have result without repeat)
     * 
     *  for example:  
     *  for table with string field key,data
     *  ['key', 'data']
     * 
     * 
     * @return object:  class object
     */
    public function select(array $poles, $distinct = false)
    {
        $this->query = "SELECT ".($distinct?'DISTINCT':'') ;
        if(count($poles) == 0)
            throw new Exception(FATAL_ERR);
        else
        {
            //error name poles - when poles name repeat
            $uniq = array_unique($poles);
            if(count($uniq) != count($poles))
            {
                $this->query = null;
                return $this;
            } 

            $tempPolesTN = [];
            $tempPoles = [];
            foreach($poles as &$column)
            {
                if(strpos($column,'.')!==false)
                {
                    $ar = explode('.',$column);
                    $tempPolesTN[]=$ar[1];

                    if($this->sbd == MYSQL)
                       $ar[1] = '`'.$ar[1].'`';
                    $column = $ar[0].'.'.$ar[1];   
                }
                else
                {
                    $tempPoles[] = $column;
                    if($this->sbd == MYSQL)
                        $column = '`'.$column.'`';
                }
            }
    
            //if you have the same poles in tables 
            //have error like SELECT id, producer.id...
            $intersect = array_uintersect($tempPolesTN, $tempPoles, "strcasecmp");
            if(count($intersect))
            {
                $this->query = null;
                return $this;
            } 

            $polesStr = implode(", ", $poles);
            $this->query .= $polesStr;
        }
        $this->ifUpdate = false;
        $this->ifInsert = false;
        $this->ifSelect = true;

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
        $this->ifSelect = false;

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
        $this->ifSelect = false;

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
        $this->ifSelect = false;

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
        
        $poles = implode(", ", $tempPole);
        $values = implode(", ",array_values($poleVal));
       
        $this->insertPart = "(".$poles.") VALUES (".$values.")";

        return $this;
    }


    /*
     * function forms part of the query indicating which table is working with
     * FROM tableName
     *
     * @param $tableName: string - name worksheet
     * 
     * @return object:  class object
     */
    public function from($tableName)
    {
        $this->fromPart = 
            ($this->ifInsert || $this->ifUpdate) ? $tableName : " FROM $tableName";

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
        if(is_null($this->query)) 
        {
            $this->execQuery = null;
            return $this;
        }

        //else
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
            {
                $this->execQuery .= $this->fromPart." ";
                $this->ifJoin();
                $this->execQuery .= " ".$this->setPart." ".$this->wherePart;
            }
            else if($this->ifSelect)
            {
                $this->execQuery .=$this->fromPart." ";
                $this->ifJoin();
                
                $this->execQuery .= " ".$this->wherePart;
                if($this->groupPart) $this->execQuery .= " ".$this->groupPart;
                if($this->havingPart) $this->execQuery .= " ".$this->havingPart;
                if($this->orderPart) $this->execQuery .= " ".$this->orderPart;
                if($this->limitPart) $this->execQuery .= " ".$this->limitPart;

            }
            else
            {    
                $this->execQuery .= $this->fromPart." ";
                $this->ifJoin();
                $this->execQuery .= " ".$this->wherePart;

            }
            
            return $this;
    }

    protected function ifJoin()
    {
         if($this->joinPart) $this->execQuery .= $this->joinPart;
         else if($this->leftJoinPart) $this->execQuery .= $this->leftJoinPart;
         else if($this->rightJoinPart) $this->execQuery .= $this->rightJoinPart;
         else if($this->crossJoinPart) $this->execQuery .= $this->crossJoinPart;
         else if($this->naturalJoinPart) $this->execQuery .= $this->naturalJoinPart;
    }

    /*
     *return exectQuery
     */
    public function getExecQuery()
    {
        return $this->execQuery;
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

        $polesStr = implode(", ", $poles);
        
        array_walk($what, 'quotation_marks', "'");
        
        $temp = $this->ecranKey($what);
        $strCond = implode(" AND ",$temp);
        
        return "SELECT $polesStr FROM $this->tableName WHERE $strCond";
       
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
            {
                 if(strpos($key,'.')!==false)
                {
                    $ar = explode('.',$key);
                    if($this->sbd == MYSQL)
                       $ar[1] = '`'.$ar[1].'`';
                    $key = $ar[0].'.'.$ar[1];   
                }
                else
                    $key = "`".$key."`";
            }
            $temp[] =  "$key = $val"; 
        }
        
        return $temp;
    }

  /*
   * Methods that form part of a join table in from-part
   *
   * @return object:  class object
   */
   public function join($tableName, $condition)
   {
       $this->joinPart = ' JOIN '.$tableName.' ON '.$condition;

       return $this;
   }

   public function leftJoin($tableName, $condition)
   {
       $this->leftJoinPart = ' LEFT OUTER JOIN '.$tableName.' ON '.$condition;

       return $this;
   }

   public function rightJoin($tableName, $conditions)
   { 
       $this->rightJoinPart = ' RIGHT OUTER JOIN '.$tableName.' ON '.$condition;

       return $this;
   }

   public function crossJoin($tableName)
   { 
       $this->crossJoinPart = ' CROSS JOIN '.$tableName;

       return $this;
   }

   public function naturalJoin($tableName)
   { 
       $this->naturalJoinPart = ' NATURAL JOIN '.$tableName;

       return $this;
   }

    /*
     *shaping combining repetitive values in groups
     *
     *@param $columns: array poles
     *
     * for example:
     * poles like'test.id' or 'price'
     *
     *@return object: class object
     */
    public function group($columns = [])
    {
        foreach($columns as &$column)
        {
            if(strpos($column,'.')!==false)
            {
                $ar = explode('.',$column);
                 if($this->sbd == MYSQL)
                     $ar[1] = '`'.$ar[1].'`';
                 $column = $ar[0].'.'.$ar[1];
            }
        }
        $poles = implode(', ',$columns);
        $this->groupPart = ' GROUP BY '.$poles;

        return $this;
    }

   /*
    *if you have condition on group
    */
   public function having($conditions)
   {
       $this->havingPart = "HAVING ".$conditions;
        return $this;
   }

   /*
    *setting sorting condition
    */
   public function order($columns, $direction = true)
   {
        if($this->sbd == MYSQL)
            array_walk($columns, 'quotation_marks' , "`");
        
        $poles = implode(", ", $columns);

        $this->orderPart = 'ORDER BY '.$poles. ($direction ? ' ASC':' DESC');

        return $this;
   }

   /*
    * limit on the number of selected records
    */
   public function limit($limit, $offset = null)
   {
       $limit = (int)$limit;
       if(!is_null($offset)) $offset = (int)$offset;
       $this->limitPart = 'LIMIT '.$limit.(!is_null($offset)?','.$offset:'');

       return $this;
   }







}

