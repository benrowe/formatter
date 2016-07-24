<?php

namespace Benrowe\Formatter\Providers;

use Benrowe\Formatter\AbstractFormatterProvider;

class Numbers extends AbstractFormatterProvider
{
    public function asCurrency($value)
    {

    }

    public function asUnsigned($value)
    {

    }

    /**
     * [asNumber description]
     * @param  [type] $value [description]
     * @return [type]        [description]
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
