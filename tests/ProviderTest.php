<?php

use Benrowe\Formatter\Test\Examples\SampleProvider;

class ProviderTest extends PHPUnit_Framework_TestCase
{
    private $provider;

    public function setUp()
    {
        $this->provider = new SampleProvider();
    }

    public function testFormats()
    {
        $this->assertSame(['return', 'rot', 'case'], $this->provider->formats());
    }
}
