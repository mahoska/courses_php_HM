<?php 

class MySql
{
    private $pdo;
    
    public function __construct()
    {
        $this->pdo = DbConnection::getInstance(MYSQL)->getLink();
    }
    
    public function setData($key, $value)
    {
        if(!$this->isKey($key))
        {
            $sth = $this->pdo->prepare('INSERT INTO '.TABLE_NAME. ' VALUES (:key, :value)');
            $res = $sth -> execute(array(':key' => $key, ':value' => $value)); 
            return $res;
        }
        else if ($this->isKey($key)!= $value)
        {
            $sth = $this->pdo->prepare('UPDATE '.TABLE_NAME. ' SET '.VAL_FIELD.' = :value');
            $res = $sth -> execute(array(':value' => $value)); 
            return $res;
        }
 
    }

    public function readData($key)
    {
        $sth = $this->pdo->prepare('SELECT `'.VAL_FIELD.'`  FROM '.TABLE_NAME. ' WHERE `'.KEY_FIELD.'`= :key');
        $sth -> execute(array(':key' => $key));
        $res = $sth->fetch(PDO::FETCH_ASSOC);
        return $res ? $res[VAL_FIELD] : false;
    }

    public function deleteData($key)
    {
        $sth = $this->pdo->prepare('DELETE  FROM '.TABLE_NAME.' WHERE `'.KEY_FIELD.'` = :key');
        return $sth -> execute(array(':key' => $key));
    }
    
    public function isKey($key)
    {
        $res = $this->readData($key);
        return $res !==false > 0 ? $res : false;
    }

}
