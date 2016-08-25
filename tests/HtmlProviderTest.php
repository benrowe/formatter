<?php

use \Benrowe\Formatter\Providers\Html;

class HtmlProviderTest extends PHPUnit_Framework_TestCase
{
    private $provider;

    public function setUp()
    {
        $this->provider = new Html;
    }

    public function dataImage()
    {
        return [
            [null, '<span>Not Set</span>'],
            ['./something.jpg', '<img src="./something.jpg">'],
        ];
    }

    public function dataLink()
    {
        return [
            [null, '<span>Not Set</span>'],
            ['http://www.github.com', '<a href="http://www.github.com">http://www.github.com</a>'],
        ];
    }

    /**
     * @dataProvider dataImage
     */
    public function testImage($expected, $actual)
    {
        $this->assertSame($this->provider->asImage($expected), $actual);
    }

    /**
     * @dataProvider dataLink
     */
    public function testLink($expected, $actual)
    {
        $this->assertSame($this->provider->asLink($expected), $actual);
    }
}
