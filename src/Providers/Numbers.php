<?php

namespace Benrowe\Formatter\Providers;

use Benrowe\Formatter\AbstractFormatterProvider;

class Numbers extends AbstractFormatterProvider
{
    /**
     * Display the value as currency
     *
     * @param  mixed $value 
     * @return string
     */
    public function asCurrency($value)
    {

    }

    /**
     * Displays the number as an unsigned value
     *
     * @param  mixed $value
     * @return float|int
     */
    public function asUnsigned($value)
    {

    }

    /**
     * Format the supplied value as a number
     *
     * @param  mixed $value
     * @return float|int
     */
    public function asNumber($value)
    {

    }

    /**
     * Convert the supplied value into a valid number value
     *
     * @param  mixed $value
     * @return float
     */
    private function normaliseValue($value)
    {
        if (!is_numeric($value)) {
            $value = 0;
        }
        return (float)$value;
    }
}
