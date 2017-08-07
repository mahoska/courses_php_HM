<?php

class Band implements iBand
{
    use AuxiliaryFunctional;
    
    private $name;
    private $ganre;
    private $musicians; //array
    
    public function __construct($name, $ganre) 
    {
        $this->name = $name;
        $this->ganre = $ganre;
        $this->musicians = [];
    }
    
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
        if(!$this->inArray($this->musicians, $obj))
                return;
    
        $this->musicians[] =  $obj;
    }
    
    public function getMusician()
    {
        return $this->musicians;
    }
}
