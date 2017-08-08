<?php
abstract  class Sql
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
    protected $limitPart;
    protected $orderPart;
    
    protected $link;
    protected $sbd;

 

    public function __construct($sbd){
        $this->ifInsert = false;
        $this->ifUpdate = false;
        $this->ifSelect = false;
        $this->isUniqueRecord = false;
        $this->ifExec = false;
        $this->orderPart = false;
        $this->orderPart = false;
    }
    
    public  function __destruct(){}
    
    
    public function select(array $poles)
    {
        $this->query = "SELECT " ;
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
            if($this->sbd == MYSQL)
                array_walk($poles, 'quotation_marks', "`");
    
            $polesStr = implode(", ", $poles);
            $this->query .= $polesStr;
        }
        $this->ifUpdate = false;
        $this->ifInsert = false;
        $this->ifSelect = true;

        return $this;
    }
    
    public function delete()
    {
        $this->query = "DELETE";
        $this->ifUpdate = false;
        $this->ifInsert = false;
        $this->ifSelect = false;

        return $this;
    }

    public  function update()
    {
        $this->query = "UPDATE";
        $this->ifUpdate = true;
        $this->ifInsert = false;
        $this->ifSelect = false;

        return $this;
    }

     public function set(array $what)
    {
        $this->setPart = "SET";

        array_walk($what, 'quotation_marks', "'");
        $temp = $this->ecranKey($what);
        
        $this->setPart .= " ".implode(", ",$temp);

        return $this;
    }

    public function insert()
    {
        $this->query = "INSERT INTO";
        $this->ifUpdate = false;
        $this->ifInsert = true;
        $this->ifSelect = false;

        return $this;
    }

    public function setting(array $poleVal)
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

    public function from()
    {
        $this->fromPart = 
            ($this->ifInsert || $this->ifUpdate) ? $this->tableName : " FROM $this->tableName";

        return $this;
    }
    
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
                $this->execQuery .= $this->fromPart." ".$this->setPart." ".$this->wherePart;
            }
            else if($this->ifSelect)
            {
                $this->execQuery .=$this->fromPart." ".$this->wherePart;
                if($this->orderPart) $this->execQuery .= " ".$this->orderPart;
                if($this->limitPart) $this->execQuery .= " ".$this->limitPart;
            }
            else
            {    
                $this->execQuery .= $this->fromPart. " ".$this->wherePart;
            }
            
            return $this;
    }

    
    public function getExecQuery()
    {
        return $this->execQuery;
    }
    
    
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
   
    protected  function ecranKey($what)
    {
        $temp = array();
        foreach($what as $key=>$val)
        {
            if($this->sbd == MYSQL)
                $key = "`".$key."`";
            $temp[] =  "$key = $val"; 
        }
        
        return $temp;
    }

  
   public function order($columns, $direction = true)
   {
       if($this->sbd == MYSQL)
            array_walk($columns, 'quotation_marks' , "`");
        
        $poles = implode(", ", $columns);

        $this->orderPart = 'ORDER BY '.$poles. ($direction ? ' ASC':' DESC');

        return $this;
   }


   public function limit($limit, $offset = null)
   {
       $limit = (int)$limit;
       if(!is_null($offset)) $offset = (int)$offset;
       $this->limitPart = 'LIMIT '.$limit.(!is_null($offset)?','.$offset:'');

       return $this;
   }







}

