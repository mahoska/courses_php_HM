<?php
class SelectRegExpTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->xml = new DomDocument;
        $this->xml->loadXML('<foo><bar>Baz</bar><bar>Baz</bar></foo>');
    }

    public function testAbsenceFailure()
    {
        $this->assertSelectRegExp('foo bar', '/Ba.*/', FALSE, $this->xml);
    }

    public function testPresenceFailure()
    {
        $this->assertSelectRegExp('foo bar', '/B[oe]z]/', TRUE, $this->xml);
    }

    public function testExactCountFailure()
    {
        $this->assertSelectRegExp('foo bar', '/Ba.*/', 5, $this->xml);
    }

    public function testRangeFailure()
    {
        $this->assertSelectRegExp('foo bar', '/Ba.*/', array('>'=>6, '<'=>8), $this->xml);
    }
}
?>
