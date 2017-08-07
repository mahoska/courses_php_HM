<?php

class Musician implements iMusician
{
    use AuxiliaryFunctional;
    
    private $name;
    private $instruments; //array
    private $nameBands;  //array
    private $musicianType;  //array
    
    public function __construct($name) {
        $this->name = $name;
        $this->instruments = [];
        $this->nameBands = [];
        $this->musicianType = [];
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function addInstrument(iInstrument $obj)
    {
        if(!$this->inArray($this->instruments, $obj))
                return;
                
        $this->instruments[] = $obj;       
    }
    
    public function getInstrument()
    {
        return $this->instruments;
    }
    
    //Adds a group to the list of groups in which the musician was
    public function assingToBand(iBand $nameBand)
    {
        if(!$this->inArray($this->nameBands, $nameBand))
                return;
                
        $this->nameBands [] = $nameBand;
    }
    
    //Returns the list of groups in which the musician was composed
    public function getAssingBands()
    {
        return $this->nameBands;
    }
    
    public function setMusicianType($musicianType)
    {
        if(!$this->inArray($this->musicianType, $musicianType))
                return;
        
        $this->musicianType[] =  $musicianType;
    }
    
    public function getMusicianType()
    {
        return $this->musicianType;
    }
    
    public function __toString() {
        $str = 'Musitian: <b>'.$this->getName().'</b><br>';
        if(count($this->musicianType)>0){
            $str.='MusicianType:';
            $str .= '<ul>';
            foreach ($this->musicianType as $type)
                $str .='<li>'.$type.'</li>';
            
            $str .= '</ul>';
        }
        if(count($this->nameBands)>0){
            $str.='Bands in which:';
            $str .= '<ul>';
            foreach ($this->nameBands as $band)
                $str .='<li>'.$band->getName().'</li>';
            
            $str .= '</ul>';
        }
        if(count($this->instruments)>0){
            $str.='Instruments:';
            $str .= '<ul>';
            foreach ($this->instruments as $instrument)
                $str .='<li>'.$instrument->getName().'</li>';
            
            $str .= '</ul>';
        }
               
        return $str;        
    }
}

