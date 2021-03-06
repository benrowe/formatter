<?php

use Benrowe\Formatter\Formatter;
use Benrowe\Formatter\Tests\Examples\NumberSampleProvider;
use Benrowe\Formatter\Tests\Examples\SampleProvider;
// use stdObject;

/**
 * Test sample providers
 */
class FormatterProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Formatter
     */
    private $formatter;

    public function setUp()
    {
        $this->formatter = new Formatter([
            'number' => new NumberSampleProvider,
            'sample' => 'Benrowe\Formatter\Tests\Examples\SampleProvider'
        ]);
    }

    public function testConstructor()
    {
        $formatter = new Formatter([
            'number' => new NumberSampleProvider,
            'sample' => 'Benrowe\Formatter\Tests\Examples\SampleProvider'
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

    public function testInvalidFormatArray()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->formatter->format('value', 'number.');
    }

    public function testFormat()
    {
        $this->assertSame($this->formatter->format('foo', 'sample.return'), 'foo');

        // $this->assertSame($this->formatter->format('foo', ['sample.case', SampleProvider::CASE_UPPER]), 'FOO');
    }
}
