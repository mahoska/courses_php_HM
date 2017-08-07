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
$basGuitar  = new Instrument('bas-guitar','stringed instrument');
$synthesizer  = new Instrument('synthesizer','keyboard instrument');

$nik  = new Musician('Nik');
$tony  = new Musician('Tony');
$john  = new Musician('John');
$rob  = new Musician('Rob');
$colin  = new Musician('Colin');
$kate  = new Musician('Kate');
$rikki  = new Musician('Rikki');
$margaret  = new Musician('Margaret');
$mike  = new Musician('Mike');
$louise  = new Musician('Louise');


$animals = new Band('Animals', 'rock');
$iceAndFire = new Band('Ice and fire', 'rock');
$life = new Band('Life', 'jazz');
$moon = new Band('Moon', 'jazz');
$rain = new Band('Rain', 'jazz');
$forever = new Band('Forever', 'classic');

$nik->setMusicianType('keyboardist');
$nik->setMusicianType('keyboardist');//testing repeat
$nik->setMusicianType('back_vocalist');
$nik->addInstrument($synthesizer);
$nik->addInstrument($basGuitar);
$nik->assingToBand($iceAndFire);



$tony->setMusicianType('vocalist');
$tony->setMusicianType('guitar player');
$tony->addInstrument($gitare);
$tony->addInstrument($gitare);//testing repeat
$tony->assingToBand($forever);

$john->setMusicianType('violinist');
$john->addInstrument($violin);
$john->assingToBand($life);
$john->assingToBand($moon);


$rob->setMusicianType('drummer');
$rob->addInstrument($drum);
$rob->assingToBand($animals);

$colin->setMusicianType('bass guitar player');
$colin->setMusicianType('soloist');
$colin->addInstrument($basGuitar);
$colin->addInstrument($gitare);
$colin->assingToBand($iceAndFire);


$kate->setMusicianType('violinist');
$kate->addInstrument($violin);


$rikki->setMusicianType('drummer');
$rikki->addInstrument($drum);


$margaret->setMusicianType('vocalist');


$mike->setMusicianType('bass guitar player');
$mike->addInstrument($basGuitar);
$mike->addInstrument($gitare);

$louise->setMusicianType('drummer');
$louise->addInstrument($drum);


$animals->addMusician($nik);
$animals->addMusician($rikki);
$iceAndFire->addMusician($rob);
$iceAndFire->addMusician($mike);
$rain->addMusician($colin);
$rain->addMusician($louise);
$life->addMusician($tony);
$forever->addMusician($john);
$moon->addMusician($kate);
$moon->addMusician($margaret);


$bands = [$animals, $iceAndFire, $rain, $life, $forever, $moon];
$fullInfo = [];
foreach ($bands as $band)
{
    $musicians = $band->getMusician();
    $music = [];
    if(count($musicians) >0)
    {
        foreach ($musicians as $musician)
        {
            $instruments = $musician->getInstrument();
            $instr = [];
            if(count($instruments)>0){
                foreach($instruments as $instrument)
                {
                    $instr[] = ['name'=>$instrument->getName(), 'category'=>$instrument->getCategory()];
                }
            }
            $asBands = $musician->getAssingBands();
            $asMusBand = [];
            if(count($asBands)>0){
                foreach($asBands as $aBand)
                {
                    $asMusBand[] = $aBand->getName();
                }
            }
            $music[] = ['name'=>$musician->getName(), 'type'=>$musician->getMusicianType(), 'instruments'=>$instr, 'assignBands'=>$asMusBand];
        }
    }
    $fullInfo[] = ['name'=>$band->getName(), 'type'=>$band->getGenre(), 'musician'=>$music];
}


include ('templates/index.php');