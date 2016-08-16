<?php

namespace Benrowe\Formatter\Providers;

use Benrowe\Formatter\AbstractFormatterProvider;

/**
 * @package Benrowe\Formatter
 */
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
        if ($value === null) {
            return $this->nullValue;
        }

        $value = $this->normaliseValue($value);

        $prefix = '$';
        if ($value < 0) {
            $prefix = '-$';
            $value *= -1;
        }

        $newValue = number_format($value, 2);

        return $prefix.$newValue;
    }

    /**
     * Displays the number as an unsigned value
     *
     * @param  mixed $value
     * @return float|int
     */
    public function asUnsigned($value)
    {
        if ($value === null) {
            return $this->nullValue;
        }

        $value = $this->normaliseValue($value);
        if ($value < 0) {
            $value *= -1;
        }
        return $value;
    }

    /**
     * Format the supplied value as a number
     *
     * @param  mixed $value
     * @return float|int
     */
    public function asNumber($value)
    {
        if ($value === null) {
            return $this->nullValue;
        }
        
        return $this->normaliseValue($value);
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
        // cast the value to int or float based on its true type
        return (float)$value === (float)(int)$value ? (int)$value : (float)$value;
    }
}
