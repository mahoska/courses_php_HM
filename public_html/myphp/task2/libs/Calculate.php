<?php

class Calculate
{
    private $number1;
    private $number2;
    private static  $buffer;

    public function  __construct($num1, $num2 = DEFAULT_NUMBER)
    {
        $this->setNumber1($num1);
        $this->setNumber2($num2);
        self::$buffer = CLEAR_BUFFER;
    }

    public function __destruct()
    {
    }
    
    public function setNumber1($num1)
    {
        //$this->number1=(is_int($num1)||is_float($num1))? $num1 : .0;
        $this->number1 = (float)$num1;
    }

    public function setNumber2($num2)
    {
        //$this->number2=(is_int($num2)||is_float($num2))? $num2 : .0;
         $this->number2 = (float)$num2;
    }

    public function  getNumber1()
    {
        return $this->number1;
    }

    public function getNumber2()
    {
        return $this->number2;
    }

    private static  function setBuffer($num)
    {
        //self::$buffer =(is_int($num)||is_float($num))? $num : 0;
        self::$buffer = (float)$num;
    }

    private static function getBuffer()
    {
        return isset(self::$buffer) ? self::$buffer : CLEAR_BUFFER;
    }

    public function plus()
    {
        return $this->number1 + $this->number2;
    }

    public function minus()
    {
        return $this->number1 - $this->number2;
    }

    public function multy()
    {
        return $this->number1 * $this->number2;
    }

    public function devide()
    {
        if(0 != $this->number2)
        {
            return $this->number1 / $this->number2;
        }
        else{
            return ERR_DEL;
        }
    }

    public function radical()
    {
        if($this->number1 < 0)
        {
            return ERR_SQRT;
        }
        else
            return sqrt($this->number1);
    }

    public function procent()
    {
        return abs($this->number1)*abs($this->number2)/PROCENT;
    }

    public static  function memorySave($num)
    {
        self::setBuffer($num);
    }

    public static  function memoryReturn()
    {
        return self::getBuffer();
    }

    public static  function memoryClear()
    {
        self::setBuffer(CLEAR_BUFFER);
    }

    public static function memoryPlus($num)
    {
        self::setBuffer(self::getBuffer() + (float)$num);
    }

    public static function memoryMinus($num)
    {
        self::setBuffer(self::getBuffer() - (float)$num);
    }


}
