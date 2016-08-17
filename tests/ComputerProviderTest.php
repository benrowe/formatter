<?php

use Benrowe\Formatter\Providers\Computer;

class ComputerProviderTest extends PHPUnit_Framework_TestCase
{
    private $provider;

    public function setUp()
    {
        $this->provider = new Computer;
    }

    public function dataFilesize()
    {
        return [
            [null, '<span>Not Set</span>'],
            [0, '0.00B'],
            [1, '1.00B'],
            [-1, '0.00B'],
            ['string', '0.00B'],
            [1001, '0.98kB'],
            [1024, '1.00kB'],
            [1024 * 1.5, '1.50kB'],
            [1024 * 1.68, '1.68kB'],
            [1024 * 1.68, '1.68kB'],
            [1024 * 1.9999, '2.00kB'],
            [2048, '2.00kB'],
        ];
    }

    /**
     * @dataProvider dataFileSize
     */
    public function testFileSize($expected, $actual)
    {
        $this->assertSame($this->provider->asFilesize($expected), $actual);
    }
}
