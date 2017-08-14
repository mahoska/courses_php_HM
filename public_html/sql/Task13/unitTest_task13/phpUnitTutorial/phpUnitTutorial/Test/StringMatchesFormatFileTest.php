<?php
class StringMatchesFormatFileTest extends PHPUnit_Framework_TestCase
{
    public function testFailure()
    {
        $this->assertStringMatchesFormatFile('../dataTest/expected4_48.txt', 'foo');
    }
}
?>
