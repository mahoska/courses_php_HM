<?php

trait AuxiliaryFunctional
{
    public function inArray($ar, $obj)
    {
        if(count($ar) >0) 
        {
            foreach($ar as $el)
                if($el === $obj)
                    return false;
        }
        return true;
    }
}

