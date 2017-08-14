<?php
class JsonFileEqualsJsonFileTest extends PHPUnit_Framework_TestCase
{
    public function testFailure()
    {
        $this->assertJsonFileEqualsJsonFile(
          '../dataTest/fixture/file', '../dataTest/actual/file');
    }
}
?>
