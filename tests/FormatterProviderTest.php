<?php

use Benrowe\Formatter\Formatter;
use Benrowe\Formatter\Providers\Numbers;
// use stdObject;

class FormatterProviderTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $formatter = new Formatter([
            'number' => new Numbers,
        ]);
        $this->assertTrue($formatter->hasFormat('number.unsigned'));
    }

    public function testInvalidFormatter()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $formatter = new Formatter([
            'fake' => new stdClass,
        ]);
    }
}
