<?php
class JsonStringEqualsJsonStringTest extends PHPUnit_Framework_TestCase
{
    public function testFailure()
    {
        $this->assertJsonStringEqualsJsonString(
          json_encode(array("Mascot" => "Tux")), json_encode(array("Mascott" => "ux"))
        );
    }
}
?>
