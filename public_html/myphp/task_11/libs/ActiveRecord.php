<?php

class ActiveRecord extends MySql
{
    protected $fields;
    protected $uniqueField;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->tableName = TABLE_NAME;
        $this->result = mysqli_query($this->link, "SHOW FIELDS FROM ".$this->tableName);
        if(!$this->result)
            throw new Exception ('ERROR_READING_TABLE');
        
        while($row =  mysqli_fetch_assoc($this->result)) {  
            $this->fields[$row['Field']] = null;
        }
        var_dump($this->fields);
    }
    
    public function __set($name, $value) 
    {
        if(!array_key_exists($name, $this->fields))
            throw new Exception ('ERROR_EXIST_FIELD');  
        
        $this->fields[$name] = $value;
    }
//
//    public function __get($name) 
//    {
//        if (!array_key_exists($name, $this->fields)) 
//            throw new Exception ('ERROR_EXIST_FIELD'); 
//        
//        return $this->fields[$name];
//    }
//    
//    
//    public function __isset($name) 
//    {
//        return isset($this->fields[$name]);
//    }
//    
//    public function setUnique($name)
//    {
//        if (!array_key_exists($name, $this->fields)) 
//                $this->uniqueField = $name;
//    }
//    
//    
//    public function save()
//    {
//       // $res = $this->insert()->from($this->tableName)->setting($this->fields)->setUniqueRecord(array($this->uniqueField=>$this->fields[$this->uniqueField]))->exec();
//
//    }
//    
//    public function delete()
//    {
//        
//    }
//    
//    public function find()
//    {
//        
//    }
//    
//    public function updateByKey()
//    {
//        
//    }
}

