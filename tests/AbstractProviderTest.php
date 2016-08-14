<?php

use Benrowe\Formatter\Tests\Examples\SampleProvider;

/**
 * Test a concrete version of the AbstractFormatterProvider
 * Ensure that the formatters are available
 */
class AbstractProviderTest extends PHPUnit_Framework_TestCase
{
    private $provider;

    public function setUp()
    {
        $this->provider = new SampleProvider();
    }

    public function testAvailableFormats()
    {
        $this->assertSame(['return', 'rot', 'case'], $this->provider->formats());
        $this->assertSame('foo', $this->provider->asReturn('foo'));
        $this->assertSame('foo', $this->provider->format('foo', 'return'));
    }

    public function testHasFormat()
    {
        $this->assertTrue($this->provider->hasFormat('return'));
        $this->assertFalse($this->provider->hasFormat('doesnotexist'));
    }

    // public function testInvalidFormatName()

    /**
     * @dataProvider invalidFormats
     */
    public function testInvalidFormatName($formatName)
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->provider->hasFormat($formatName);
    }

    public function testInvalidFormat()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->provider->format('value', 'doesntexist');
    }
    public function testInvalidFormatArray()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->provider->format('value', ['']);
    }

    public function invalidFormats()
    {
        return [
            'funkyChars' => ['!'],
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     *
     */
    public function testInvalidFormatNameSyntax()
    {
        $this->provider->hasFormat('something.something');

    }
}
