<?php

class DateTimeProviderTest extends PHPUnit_Framework_TestCase
{
    protected $provider;

    public function setUp()
    {
        $this->provider = new \Benrowe\Formatter\Providers\DateTime;
    }

    public function dataDurationHuman()
    {
        return [
            [null, '<span>Not Set</span>'],
            [20, '20 Seconds'],
            [120, '2 Minutes'],
            [121, '2 Minutes and 1 Second'],
            [122, '2 Minutes and 2 Seconds'],
            [1, '1 Second'],
            // [0, ''],
        ];
    }

    public function dataDate()
    {
        return [
            [time(), date('Y-m-d')],
            ['2009-01-13 14:55:49', '2009-01-13'],
            ['2009/01/13 14:55:49', '2009-01-13'],
        ];
    }

    /**
     * @dataProvider dataDate
     */
    public function testDate($expected, $actual)
    {
        $this->assertSame($this->provider->asDate($expected), $actual);
    }

    public function testTime()
    {
        $this->assertSame($this->provider->asTime(time()), date('H:i:s'));
        $this->assertSame($this->provider->asTime(time(), 'i'), date('i'));
    }

    public function testDateTime()
    {
        $this->assertSame($this->provider->asDateTime(time()), date('Y-m-d H:i:s'));
    }

    /**
     * @dataProvider dataDurationHuman
     */
    public function testDurationHuman($expected, $actual)
    {
        $this->assertSame($this->provider->asDurationHuman($expected), $actual);
    }

    public function testBetween()
    {

    }
}
