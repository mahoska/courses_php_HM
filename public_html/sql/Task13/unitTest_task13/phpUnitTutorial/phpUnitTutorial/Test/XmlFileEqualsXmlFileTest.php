<?php
class XmlFileEqualsXmlFileTest extends PHPUnit_Framework_TestCase
{
    public function testFailure()
    {
        $this->assertXmlFileEqualsXmlFile(
          '../dataTest/ex4_60/expected.xml', '../dataTest/ex4_60/actual.xml');
    }
}
?>
