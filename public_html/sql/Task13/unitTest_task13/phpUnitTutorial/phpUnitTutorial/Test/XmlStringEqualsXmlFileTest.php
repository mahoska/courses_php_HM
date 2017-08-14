<?php
class XmlStringEqualsXmlFileTest extends PHPUnit_Framework_TestCase
{
    public function testFailure()
    {
        $this->assertXmlStringEqualsXmlFile(
          '../dataTest/ex4_60/expected.xml', '<foo><baz/></foo>');
    }
}
?>
