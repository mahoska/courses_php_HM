<?php
class SelectCountTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->xml = new DomDocument;
        $this->xml->loadXML('<foo><bar/><bar/><bar/></foo>');
    }

    public function testAbsenceFailure()
    {
        $this->assertSelectCount('foo bar', FALSE, $this->xml);
    }

    public function testPresenceFailure()
    {
        $this->assertSelectCount('foo baz', TRUE, $this->xml);
    }

    public function testExactCountFailure()
    {
        $this->assertSelectCount('foo bar', 5, $this->xml);
    }

    public function testRangeFailure()
    {
        $this->assertSelectCount('foo bar', array('>'=>6, '<'=>8), $this->xml);
    }
}
?>
