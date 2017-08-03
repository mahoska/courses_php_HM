<?php

spl_autoload_register(function($className){
        $file =  'libs/'.$className.'.php';
        if(!file_exists($file)){
            throw new Exception("$file not found".PHP_EOL.__FILE__.PHP_EOL."- in ".__LINE__.PHP_EOL);
        }
        require_once $file;
    });
    
$gitare  = new Instrument('gitare','stringed instrument');
$violin  = new Instrument('violin','stringed instrument');
$drum  = new Instrument('drum','percussion instrument');
$basGuitar  = new Instrument('$bas-guitar','stringed instrument');
$synthesizer  = new Instrument('synthesizer','keyboard instrument');


$vokalist  = new Instrument('gitare','stringed instrument');
$violin  = new Instrument('violin','stringed instrument');
$drum  = new Instrument('drum','percussion instrument');
$basGuitar  = new Instrument('$bas-guitar','stringed instrument');
$synthesizer  = new Instrument('synthesizer','keyboard instrument');