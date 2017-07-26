<?php
class SQL
{
    protected $query;
    protected $execQuery;
    protected $fromPart;
    protected $wherePart;
    protected $setPart;
    protected $ifUpdate;
    protected $insertPart;
    protected $ifInsert;

    public function select(array $poles = [], $distinct = false)
    {
        $this->query = "SELECT ".(($distinct)?"DISTINCT ":"");
        if(empty($poles))
            throw new Exception("not selected poles in select");
        else
        {
            $polesStr = implode(", ", $poles);
            $this->query .= $polesStr;
        }
        $this->ifUpdate = false;
        $this->ifInsert = false;

        return $this;
    }
    
    public function delete()
    {
        $this->query = "DELETE";
        $this->ifUpdate = false;
        $this->ifInsert = false;

        return $this;
    }

    public  function update()
    {
        $this->query = "UPDATE";
        $this->ifUpdate = true;
        $this->ifInsert = false;

        return $this;
    }

    public function insert()
    {
        $this->query = "INSERT INTO";
        $this->ifUpdate = false;
        $this->ifInsert = true;

        return $this;
    }

    public function setting(array $poleVal)
    {
        $poles = implode(", ",array_keys($poleVal));
        $valuse = implode(", ", array_values($poleVal));
        
        $this->insertPart = "(".$poles.") VALUS (".$values.")";

        return $this;
    }

    public function set(array $what)
    {
        $this->setPart = "SET";
        $temp = [];
        foreach($what as $key=>$val)
        {
            $temp[] =  "$key = $val"; 
        }
        $this->setPart .= " ".implode(", ",$temp);

        return $this;
    }
    
    public function from($tableName1, $isInsert = true,  $tableName2 = null,  $rjoin = false, $ljoin = false)
    {
        $this->fromPart = ($this->ifInsert || $this->isUpdate) ? $tableName1 : " FROM $tableName1";
        if($isInsert)
        {
            $join  = "JOIN";
            if(!is_null($tableName2))
            {
                if($rjion) $join = " RIGHT JOIN";
                else if($ljoin) $join =" LEFT JOIN";
                $this->fromPart .= $join." ".$tableName2;
            }
        }
        return $this;
    }
    
    
        
    public function where($condition = null)
    {
        if(!is_null($condition))
            $this->wherePart = "WHERE ".$condition;

        return $this;
    }
        
    public function exec()
    {
            $this->execQuery = $this->query." ";
            if($this->ifInsert)
                $this->execQuery .= $this->from." ".$this->insertPart;
            else if($this->ifUpdate)
                $this->execQuery .= $this->from." ".$this->set;
            else
                $this->execQuery .= $this->fromPart." ".$this->wherePart;
    

        return $this->execQuery;
    }

}

