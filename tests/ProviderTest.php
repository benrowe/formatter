<?php

use Benrowe\Formatter\Test\Examples\SampleProvider;

class ProviderTest extends PHPUnit_Framework_TestCase
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
}
