<?php

use Benrowe\Formatter\Test\Examples\SampleProvider;

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

    /**
     * @expectedException InvalidArgumentException
     *
     */
    public function testInvalidFormatNameSyntax()
    {
        $this->provider->hasFormat('something.something');

    }
}
