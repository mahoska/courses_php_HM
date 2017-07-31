<?php

class FileReader
{
    private $filename;
    private $linesArr;
    private $countLines;
    
    public function __construct($filename){
        $this->filename = $filename;
        
        if(!file_exists($this->filename))
            throw new Exception(ERR_READ_FILE);
        
        $this->linesArr = [];
    }
    
    public function readFile()
    {
        $linesFromFile = file($this->filename);
        if($linesFromFile===false)
            throw new Exception(ERR_READ_FILE);
        
        foreach ($linesFromFile as $line_num => &$line) {
            $line =  rtrim($line, PHP_EOL);
        }

        $this->linesArr = $linesFromFile;
    }
    
    
    public function readByLine($numRow)
    {
        $numRow = (int)$numRow;
        if($numRow < 0) return null;
        $this->readFile();
        $count = count($this->linesArr);
        if($count > 0)
            return ($numRow < $count) ? $this->linesArr[$numRow] : false;
        
        return false;
    }
    
    
    public function readByChar($numRow, $numSymb)
    {    
        $numRow = (int)$numRow;
        $numSymb = (int)$numSymb;

        if($numRow < 0 || $numSymb < 0) 
            return false;
        
        $line = $this->readByLine($numRow);
        if($line === false)
            return false;
        
        $strSize = strlen($line);
        if($numSymb >= $strSize) return false;
        
        return $line[$numSymb];
    }
    
    public function replaceLine($numRow, $newLine)
    {
        $line = $this->readByLine($numRow);  
        if($line === false)
            return false;

        $this->linesArr[$numRow] = $newLine;
        return true;
    }
    
    public function replaceChar($numRow, $numSymb, $newSymb)
    {
        $symb = $this->readByChar($numRow, $numSymb);
        if($symb === false)
            return false;

        $this->linesArr[$numRow][$numSymb] = $newSymb; 
        return true;
    }
    
    public function writeFile()
    {
        foreach($this->linesArr as &$line)
            $line .= PHP_EOL;

        file_put_contents($this->filename, $this->linesArr);
    }
    
    
}

