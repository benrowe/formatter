<?php

use Benrowe\Formatter\Providers\Base;

class BaseProviderTest extends PHPUnit_Framework_TestCase
{
    private $provider;

    public function setUp()
    {
        $this->provider = new Base;
    }

    public function dataRaw()
    {
        return [
            [null, '<span>Not Set</span>'],
            ['hello', 'hello'],
            [1.1, 1.1],
            [100, 100],
        ];
    }

    public function dataText()
    {
        return [
            [null, '<span>Not Set</span>'],
            ['hello', 'hello'],
            ['<b>hello</b>', '&lt;b&gt;hello&lt;/b&gt;'],

        ];
    }

    public function dataBoolean()
    {
        return [
            [null, '<span>Not Set</span>'],
            [true, 'Yes'],
            [1, 'Yes'],
            [-1, 'Yes'],
            ['true', 'Yes'],
            ['true', 'Yes'],
            [false, 'No'],
            [0, 'No'],
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

    /**
     * @dataProvider dataText
     */
    public function testText($expected, $actual)
    {
        $this->assertSame($this->provider->asText($expected), $actual);
    }

    /**
     * @dataProvider dataBoolean
     */
    public function testBoolean($expected, $actual)
    {
        $this->assertSame($this->provider->asBoolean($expected), $actual);
    }
}
