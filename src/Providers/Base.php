<?php

namespace Benrowe\Formatter\Providers;

use Benrowe\Formatter\AbstractFormatterProvider;

/**
 * @package Benrowe\Formatter
 */
class Base extends AbstractFormatterProvider
{
    public $booleanFormat = ['No', 'Yes'];

    /**
     * Handle the raw content
     *
     * @param  mixed $value
     * @return mixed
     */
    public function asRaw($value)
    {
        if ($value === null) {
            return $this->nullValue;
        }
        return $value;
    }

    /**
     * As text
     *
     * @param  mixed $value
     * @return string
     */
    public function asText($value)
    {
        if ($value === null) {
            return $this->nullValue;
        }

        return htmlentities($value);
    }

    /**
     * Format the value using the boolean values
     *
     * @param  mixed $value
     * @return string
     */
    public function asBoolean($value)
    {
        return $value;
    }
}
