<?php 

class MySql
{

    private $pdo;
    private $tableName;
    
    public function __construct()
    {
        $this->pdo = new PDO("mysql: host=".HOST."; dbname=".DATABASE, USER, PSW);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("SET NAMES utf8");
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }
    
    
    //@param $key: array poles
     //@param $value: array values poles
    public function setData($key, $value)
    {
        array_walk($key, 'quotation_marks' , '`');
        $poles = implode(', ', $key);
        $values =  implode(', ', $value);
        echo "INSERT INTO $this->tableName ($poles)  VALUES ($value)";
        
        $stm = $this->pdo->query("INSERT INTO $this->tableName ($poles)  VALUES ($value)");
 
    }

    //@param $key: array ['pole'=>pole, 'value'=>valPole] 
    public function readData($key)
    {
        $stm = $this->pdo->query("SELECT ".$key['pole']."  FROM $this->tableName WHERE .".$key['pole']=$key['value']);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteData($key)
    {
        $stm = $this->pdo->query("DELETE   FROM $this->tableName WHERE .".$key['pole']=$key['value']);
    }

}
