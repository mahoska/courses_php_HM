<?php

class Band implements iBand
{
    private $name;
    private $ganre;
    private $musicians; //array
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setGanre($ganre)
    {
        $this->ganre = $ganre;
    }
    
    public function getGenre()
    {
        return $this->ganre;
    }
    
    public function addMusician(iMusician $obj)
    {
        
    }
    
    public function getMusician()
    {
        
    }
}
