<?php
class JsonStringEqualsJsonFileTest extends PHPUnit_Framework_TestCase
{
    public function testFailure()
    {
        $this->assertJsonStringEqualsJsonFile(
          'path/to/fixture/file', json_encode(array("Mascot" => "ux"))
        );
    }
}
?>
