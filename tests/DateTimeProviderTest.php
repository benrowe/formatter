<?php

class DateTimeProviderTest extends PHPUnit_Framework_TestCase
{
    protected $provider;

    public function setUp()
    {
        $this->provider = new \Benrowe\Formatter\Providers\DateTime;
    }

    public function testDate()
    {
        $this->assertSame($this->provider->asDate(time()), date('Y-m-d'));
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

    public function testHuman()
    {
        // $this->assertSame($this->provider->asHuman(20), '');
    }

    public function testBetween()
    {

    }
}
