<?php

class Instrument implements iInstrument
{
    private $name;
    private $category;
    
    public function __construct($name, $category)
    {
        $this->name = $name;
        $this->category = $category;
    }
    
    public function getName()
    {
        return $this->name;
    }
       
    
    public function getCategory()
    {
        return $this->category;
    }
    
    public function __toString() {
        return'Instrument: <b>'.$this->getName().'</b><br>'
                . 'Category: '.$this->getCategory().'<br>';
    }
}

