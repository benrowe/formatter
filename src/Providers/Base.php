<?php

namespace Benrowe\Formatter\Providers;

use Benrowe\Formatter\AbstractFormatterProvider;

class Base extends AbstractFormatterProvider
{
    public $booleanFormat = ['No', 'Yes'];

    public function asRaw($value)
    {
        if ($value === null) {
            return $this->nullValue;
        }
        return $value;
    }

    public function asText($value)
    {
        if ($value === null) {
            return $this->nullValue;
        }

        return htmlentities($value);
    }

    public function asBoolean($value)
    {
        return $value;
    }
}
