<?php

class BaseProviderTest extends PHPUnit_Framework_TestCase
{
    private $provider;

    public function setUp()
    {
        $this->provider = new Benrowe\Formatter\Providers\Base;
    }

    public function dataRaw()
    {
        return [
            // [null, $this->provider->nullValue],
            ['hello', 'hello'],
        ];
    }

    // public function data

    /**
     * @dataProvider dataRaw
     */
    public function testRaw($expected, $actual)
    {
        $this->assertSame($this->provider->asRaw($expected), $actual);
    }

    public function testText()
    {
        $this->assertSame($this->provider->asText('hello'), 'hello');
    }

    public function testBoolean()
    {

    }
}
