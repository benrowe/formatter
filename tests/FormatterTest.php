<?php

use Benrowe\Formatter\Formatter;

/**
 * Test the basic formatter functionality
 */
class FormatterTest extends PHPUnit_Framework_TestCase
{
    private $formatter;

    /**
     * Setup formatter instance
     */
    public function setUp()
    {
        $this->formatter = new Formatter([
            'raw' => function ($value) {
                if ($value === null) {
                    return $this->nullValue;
                }
                return $value;
            }
        ]);
    }

    public function testBasic()
    {
        $formatter = $this->formatter;
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

        $this->assertSame('neb', $formatter->format('ben', 'reverse'), 'via format()');
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

        $this->assertSame('ora', $formatter->format('ben'), 'via format()');

        $this->assertSame($formatter->nullValue, $formatter->format(null));
    }

}
