<?php

class FileEqualsTest extends PHPUnit_Framework_TestCase
{
    public function testFailure()
    {
        $this->assertFileEquals('../dataTest/sb/expected', '../dataTest/sb/actual');
    }
}
?>
