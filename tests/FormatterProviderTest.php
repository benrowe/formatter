<?php

use Benrowe\Formatter\Formatter;
use Benrowe\Formatter\Test\Examples\NumberSampleProvider;
use Benrowe\Formatter\Test\Examples\SampleProvider;
// use stdObject;

class FormatterProviderTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $formatter = new Formatter([
            'number' => new NumberSampleProvider,
            'sample' => 'Benrowe\Formatter\Test\Examples\SampleProvider'
        ]);
        $this->assertSame([
            'number.number',
            'number.unsigned',
            'sample.return',
            'sample.rot',
            'sample.case'
        ], $formatter->formats());
        $this->assertTrue($formatter->hasFormat('number.unsigned'));

    }



    public function testInvalidFormatter()
    {
        $this->setExpectedException('InvalidArgumentException');
        $formatter = new Formatter([
            'fake' => new stdClass,
        ]);
    }
}
