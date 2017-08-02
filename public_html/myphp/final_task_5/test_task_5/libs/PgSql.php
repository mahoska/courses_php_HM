<?php

class PgSql implements iData
{
    private $link;
    
    public function __construct()
    {
        $this->link = DbConnection::getInstance(PGSQL)->getLink();
        //var_dump( $this->link);
    }
    
    public function setData($key, $value)
    {
        if(!$this->isKey($key))
        { 
            echo 'INSERT INTO '.TABLE_NAME_PG. ' VALUES (\''.$key.'\', \''. $value.'\' )';
            return pg_query($this->link, 'INSERT INTO '.TABLE_NAME_PG. ' VALUES (\''.$key.'\', \''. $value.'\' )');
        }
        else if ($this->isKey($key)!= $value)
        {
            return pg_query($this->link, 'UPDATE '.TABLE_NAME_PG. ' SET "'.VAL_FIELD.'" = \''.$value.'\'');
            
        }
 
    }

    public function readData($key)
    {
        echo  'SELECT '. TABLE_NAME_PG.'."'.VAL_FIELD.'"  FROM '.TABLE_NAME_PG. ' WHERE "'.KEY_FIELD.'"= \''.$key.'\'';
        $result = pg_query($this->link,'SELECT '. TABLE_NAME_PG.'."'.VAL_FIELD.'"  FROM '.TABLE_NAME_PG. ' WHERE "'.KEY_FIELD.'"= \''.$key.'\'');
        if($result) 
        {
            $selection=array();
            while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                $selection[] = $row;
            }
            return $selection;
        }      
        return $result;
    }

    public function deleteData($key)
    {
        echo 'DELETE  FROM '.TABLE_NAME_PG.' WHERE "'.KEY_FIELD.'" = \''.$key.'\'';
        return pg_query($this->link,'DELETE  FROM '.TABLE_NAME_PG.' WHERE "'.KEY_FIELD.'" = \''.$key.'\'');
    }
    
    public function isKey($key)
    {
        $res = $this->readData($key);
        return $res !==false > 0 ? $res : false;
    }

}

