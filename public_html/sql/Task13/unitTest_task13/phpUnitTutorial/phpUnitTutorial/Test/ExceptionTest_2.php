<?php

class ExceptionTest extends PHPUnit_Framework_TestCase {
    public function testException() {
        try {
            // ... Code that is expected to raise an exception ...
        }

        catch (InvalidArgumentException $expected) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }
}
?>
