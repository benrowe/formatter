<?php

namespace Benrowe\Formatter\Test\Examples;

use Benrowe\Formatter\AbstractFormatterProvider;

class SampleProvider extends AbstractFormatterProvider
{
    const CASE_UPPER = 'upper';
    const CASE_LOWER = 'lower';

    public function asReturn($value)
    {
        return $value;
    }

    public function asRot($value)
    {
        return str_rot13($value);
    }

    public function asCase($value, $type = self::CASE_UPPER)
    {
        return strrev($value);
    }

    /**
     * This method should be ignored as a formatter
     *
     */
    public function ask()
    {
    }
}
