<?php
class SelectEqualsTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->xml = new DomDocument;
        $this->xml->loadXML('<foo><bar>Baz</bar><bar>Baz</bar></foo>');
    }

    public function testAbsenceFailure()
    {
        $this->assertSelectEquals('foo bar', 'Baz', FALSE, $this->xml);
    }

    public function testPresenceFailure()
    {
        $this->assertSelectEquals('foo bar', 'Bat', TRUE, $this->xml);
    }

    public function testExactCountFailure()
    {
        $this->assertSelectEquals('foo bar', 'Baz', 5, $this->xml);
    }

    public function testRangeFailure()
    {
        $this->assertSelectEquals('foo bar', 'Baz', array('>'=>6, '<'=>8), $this->xml);
    }
}
?>
