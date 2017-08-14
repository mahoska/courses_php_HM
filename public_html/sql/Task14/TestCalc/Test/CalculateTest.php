<?php 
 require_once ('../config.php');
 require_once ('../Calculate.php');
 
class CalculateTest extends PHPUnit_Framework_TestCase
{
    /**
    * @dataProvider providerPlus
    */
    public function testPlus($c, $a, $b)
    {
		$obj = new Calculate($a, $b);
        $this->assertEquals($c, $obj->plus());
    }
   
    public function providerPlus()
    {
        return array(
            array(6, 2, 4),
            array(-5, 3, -8),
            array(243, 0, 243)
        );
    }
	
	 /**
    * @dataProvider providerMinus
    */
    public function testMinus($c, $a, $b)
    {
		$obj = new Calculate($a, $b);
        $this->assertEquals($c, $obj->minus());
    }
   
    public function providerMinus()
    {
        return array(
            array(-2, 2, 4),
            array(11, 3, -8),
            array(243,243,0)
        );
    }
	
	 /**
    * @dataProvider providerMulty
    */
    public function testMulty($c, $a, $b)
    {
		$obj = new Calculate($a, $b);
        $this->assertEquals($c, $obj->multy());
    }
   
    public function providerMulty()
    {
        return array(
            array(8, 2, 4),
            array(-24, 3, -8),
            array(0, 243,0)
        );
    }
	
	 /**
    * @dataProvider providerDevide
    */
    public function testDevide($c, $a, $b)
    {
		$obj = new Calculate($a, $b);
        $this->assertEquals($c, $obj->devide());
    }
   
    public function providerDevide()
    {
        return array(
            array(0.5, 2, 4),
            array(-4, 32, -8),
            array(ERR_DEL, 243,0),
			array(0, 0,55)
        );
    }
	
	/**
    * @dataProvider providerRadical
    */
    public function testRadical($c, $a, $b = 0)
    {
		$obj = new Calculate($a, $b);
        $this->assertEquals($c, $obj->radical());
    }
   
    public function providerRadical()
    {
        return array(
            array(2, 4),
            array(ERR_SQRT, -32, -8),
            array(15, 225,0),
			array(0, 0,55)
        );
    }

	/**
    * @dataProvider providerProcent
    */
    public function testProcent($c, $a , $b)
    {
		$obj = new Calculate($a, $b);
        $this->assertEquals($c, $obj->procent());
    }
   
    public function providerProcent()
    {
        return array(
            array(10, 100,10),
            array(1.2, -120, 1),
            array(1.25, 250,0.5)
        );
    }
	
	/**
    * @dataProvider providerSet
    */
    public function testSet($num1, $num2, $a , $b)
    {
		$pre = new Calculate($num1, $num2);
		$pre->setNumber1($a);
		$pre->setNumber2($b);
		$aft = new Calculate($a, $b);
	
        $this->assertEquals($aft, $pre);
    }
   
    public function providerSet()
    {
        return array(
            array(0,0, 1, 5)
        );
    }
	
	/**
    * @dataProvider providerGet
    */
    public function testGet($a, $res)
    {
		$obj = new Calculate($a, 0);
        $this->assertEquals($res, $obj->getNumber1());
    }
   
    public function providerGet()
    {
        return array(
            array(5,5)
        );
    }
	
	/**
    * @dataProvider providerMemory
    */
    public function testMemory($num)
    {
		Calculate::memorySave($num);
	
        $this->assertEquals(Calculate::memoryReturn(), $num);
    }
   
    public function providerMemory()
    {
        return array(
            array(22)
        );
    }
	
	/**
    * @dataProvider providerMemoryPlus
    */
    public function testMemoryPlus($mem,$num, $res)
    {
		Calculate::memorySave($mem);
		Calculate::memoryPlus($num);
        $this->assertEquals(Calculate::memoryReturn($num), $res);
    }
   
    public function providerMemoryPlus()
    {
        return array(
            array(22.5, 32.5, 55)
        );
    }
	
	/**
    * @dataProvider providerMemoryMinus
    */
    public function testMemoryMinus($mem,$num, $res)
    {
		Calculate::memorySave($mem);
		Calculate::memoryMinus($num);
        $this->assertEquals(Calculate::memoryReturn($num), $res);
    }
   
    public function providerMemoryMinus()
    {
        return array(
            array(22.5, 32.5, -10)
        );
    }
}