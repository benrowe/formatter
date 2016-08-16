<?php

class NumbersProviderTest extends PHPUnit_Framework_TestCase
{
    private $provider;

    public function setUp()
    {
        $this->provider = new Benrowe\Formatter\Providers\Numbers;
    }

    public function dataUnsigned()
    {
        return [
            [null, '<span>Not Set</span>'],
            ['test', 0],
            [1,1],
            [-1,1],
            [0,0],
            [-0.1, 0.1]
        ];
    }

    public function dataCurrency()
    {
        return [
            [null, '<span>Not Set</span>'],
            [0, '$0.00'],
            [1, '$1.00'],
            [-1, '-$1.00'],
            [0.99, '$0.99'],
            [0.956, '$0.96'],
            [-0.956, '-$0.96'],
            [1234, '$1,234.00'],
            [1234567890, '$1,234,567,890.00'],
            [12345678901, '$12,345,678,901.00'],
            [-1234, '-$1,234.00'],
            [-1234567890, '-$1,234,567,890.00'],
            [-12345678901, '-$12,345,678,901.00'],
        ];
    }

    public function dataNumber()
    {
        return [
            [null, '<span>Not Set</span>'],
            [0, 0],
            [1, 1],
            [-1, -1],
            [1.00, 1],
            [1.50, 1.5],
        ];
    }

    /**
     * @dataProvider dataCurrency
     */
    public function testCurrency($expected, $actual)
    {
        $this->assertSame($this->provider->asCurrency($expected), $actual);
    }

    /**
     * @dataProvider dataUnsigned
     */
    public function testUnsigned($expected, $actual)
    {
        $this->assertSame($this->provider->asUnsigned($expected), $actual);
    }

    /**
     * @dataProvider dataNumber
     */
    public function testNumber($expected, $actual)
    {
        $this->assertSame($this->provider->asNumber($expected), $actual);
    }
}
