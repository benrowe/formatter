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
        $value = $this->normaliseValue($value);
        
        return (string)$value;
    }

    /**
     * Displays the number as an unsigned value
     *
     * @param  mixed $value
     * @return float|int
     */
    public function asUnsigned($value)
    {
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
        return (float)$value;
    }
}
