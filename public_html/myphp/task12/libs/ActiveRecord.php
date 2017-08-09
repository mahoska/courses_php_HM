<?php

class ActiveRecord extends MySql
{
    protected $fields;
    protected $uniqueField;
    protected $record;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->tableName = TABLE_NAME;
        $result = mysql_query( "SHOW FIELDS FROM ".$this->tableName, $this->link);
        if(!$result)
            throw new Exception ('ERROR_READING_TABLE');
        
        while($row =  mysql_fetch_assoc($result)) {  
            $this->fields[] = $row['Field'];
        }
    }
    
    public function __set($name, $value) 
    {
        if(!in_array($name, $this->fields))
            //throw new Exception ('ERROR_EXIST_FIELD');
            return;
        
        $this->record[$name] = $value;
    }

    public function __get($name) 
    {
        if (!in_array($name, $this->fields)) 
            //throw new Exception ('ERROR_EXIST_FIELD'); 
            return null;
        
        return $this->record[$name];
    }
    
    
    public function __isset($name) 
    {
        return isset($this->record[$name]);
    }
    
    //as primary
    public function setUnique($name)
    {
        if (in_array($name, $this->fields)) 
                $this->uniqueField = $name;
    }
    
    public function getUnique()
    {
        return (isset($this->uniqueField)) ? $this->uniqueField : null;
    }
    
    public function getRecord()
    {
        return $this->record;
    }
    
    public function setRecord($record)
    {
        $count = count($record);
        if($count<0 || $count != count($this->fields))
            //throw new Exception (ERROR_RECORD);
            return;
        
        $keys = array_keys($record);
        $intersection = array_uintersect($keys,$this->fields, "strcasecmp");
        if(count($intersection)!= $count)
            //throw new Exception (ERROR_RECORD);
            return;
        
        $this->record = $record;
    }
    
    public function save()
    {
        if(is_null($this->record))
            return false;

        //Check for setting field values
        foreach($this->fields as $field)
        {
            if(!isset($this->record[$field]))
                return false;
        }

        //if a unique field is defined
        if(isset($this->uniqueField))
        {
            $this->result = $this->insert()->
                            from()->
                            setting($this->record)->
                            setUniqueRecord(array($this->uniqueField=>$this->record[$this->uniqueField]))
                            ->exec();
        }
        else
        {
            $this->result = $this->insert()->
                            from()->
                            setting($this->record)->
                            exec();
        }
        return $this->result;
    }

   // finds the first condition record
    public function find($condition)
    {
        $result = $this->select($this->fields)->
                from()->where($condition)->exec()->getAssoc();
        
        
        $this->record = count($records>0)? $result[0] : null; 
        return   $this;
    }
    
    public function findAll($condition)
    {
        $result = $this->select($this->fields)->
                from()->where($condition)->exec()->getAssoc();
        
        return $result;
    }
    
    //delete a specific record
    public function delete()
    {
        $this->result = false;
        
        if(!is_null($this->record))
        {
            $values = array_values($this->record);
            array_walk($this->record, 'quotation_marks' , "'");
            $temp = $this->ecranKey($this->record);      
            $condition = implode(" AND ",$temp);
                
            $this->result = parent::delete()->
            from()->
            where($condition)->exec();
        }
        
        return $this->result;
    }
    
    //update a specific record
     public function update($field)
    {
         $this->result = false;
         
         if(!is_null($this->record))
        {
            if (!$this->checkForUpdate($field))
                return false;
           

            $values = array_values($this->record);
            array_walk($this->record, 'quotation_marks' , "'");
            $temp = $this->ecranKey($this->record);      
            $condition = implode(" AND ",$temp);
            
            $this->result = parent::update()->
            from()->
            set($field)->
            where($condition)->
            exec();
        }
        
        return $this->result;
    }
    
    
    public function updateAll($field, $condition)
    {

        if (!$this->checkForUpdate($field))
                return false;
        
        $this->result = parent::update()->
        from()->
        set($field)->
        where($condition)->
        exec();
        
        return $this->result;
    }
    
    
    public function checkForUpdate($field)
    {
        //check for an updated field
        $keys = array_keys($field);
        $key = $keys[0];

        if(!in_array($key,$this->fields))
                return false;

        //If the field is unique and it is attempted to set the value that
        // already exists in the table
        if($key == $this->uniqueField)
        {
            $values = array_values($field);
            $value = $values[0];

            $cond = '`'.$key.'` = '."'".$value."'";
            $record = $this->find($cond);
            if(!is_null($record))
                return false;
        }
        
        return true;
    }
    
}

