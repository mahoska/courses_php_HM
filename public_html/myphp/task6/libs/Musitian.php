<?php

class Musician implements iMusician
{
    private $name;
    private $instruments; //array
    private $nameBands;
    private $musicianType;
    
    public function __construct($name) {
        $this->name = $name;
        $this->instruments = [];
        $this->nameBands = [];
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
        if(count($this->instruments) >0) 
            foreach($this->instruments as $instrument)
                if($instrument->getName == $obj->getName())
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
         if(count($this->nameBands) >0) 
            foreach($this->nameBands as $nameMusicianBand)
                if($nameMusicianBand->getName == $nameBand->getName())
                    return;
                
        $this->nameBand [] = $nameBand;
    }
    
    //Returns the list of groups in which the musician was composed
    public function getAssingBands()
    {
        return $this->nameBand;
    }
    
    public function setMusicianType($musicianType)
    {
        if(count($this->musicianType) >0) 
        foreach($this->musicianType as $type)
            if($type == $musicianType)
                return;
    
        $this->musicianType =  $musicianType;
    }
    
    public function getMusicianType()
    {
        return $this->musicianType;
    }
    
    public function __toString() {
        $str = 'Musitian: <b>'.$this->getName().'</b><br>'
                . 'MusicianType: '.$this->getMusicianType().'<br>';
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

