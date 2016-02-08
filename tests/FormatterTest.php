<?php

use Benrowe\Formatter\Formatter;

class FormatterTest extends PHPUnit_Framework_TestCase
{
    public function testBasic()
    {
        $formatter = new Formatter;
        $this->assertSame('ben', $formatter->asRaw('ben'));
        $this->assertSame($formatter->nullValue, $formatter->format(null, 'raw'));
        $this->assertSame($formatter->nullValue, $formatter->format(null));
    }

    public function testCustom()
    {
        $formatter = new Formatter(['reverse' => function ($value) {

            if ($value === null) {
                return $this->nullValue;
            }

            return strrev($value);
        }]);

        $this->assertSame('neb', $formatter->format('ben', 'via format()'));
        $this->assertSame('neb', $formatter->asReverse('ben'), 'via asReverse()');

    }

    public function testOverload()
    {
        $formatter = new Formatter(['raw' => function ($value) {
            if ($value === null) {
                return $this->nullValue;
            }
            return str_rot13($value);
        }]);

        $this->assertSame('ora', $formatter->asRaw('ben'));
        $this->assertSame('ora', $formatter->format('ben'));
        $this->assertSame($formatter->nullValue, $formatter->format(null));
    }

}
