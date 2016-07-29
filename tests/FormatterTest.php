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
            },
            'return' => function ($value) {
                return $value;
            }
        ]);
    }

    /**
     * [testBasic description]
     * @return [type] [description]
     */
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

    public function testDefaultFormatter()
    {
        $this->assertSame('raw', $this->formatter->getDefaultFormatter());
        $this->formatter->setDefaultFormatter('return');
        $this->assertSame('return', $this->formatter->getDefaultFormatter());
    }

    public function testHasFormat()
    {
        $this->assertTrue($this->formatter->hasFormat('raw'));
        $this->assertFalse($this->formatter->hasFormat('doesnotexist'));
    }

    public function testHasFormatInvalidSyntax()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->formatter->hasFormat('i like spaces');
    }

    public function testAddDefaultFormatterNoExist()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->formatter->setDefaultFormatter('doesnotexist');
    }

    public function testNonExistFormat()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->formatter->format('value', 'madeup');
    }

    public function testAddFormatterInvalid()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->formatter->addFormatter('!', function($value) {
            return $value;
        });
    }

}
