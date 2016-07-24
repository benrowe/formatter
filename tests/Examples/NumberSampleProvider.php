<?php

namespace Benrowe\Formatter\Test\Examples;

use Benrowe\Formatter\AbstractFormatterProvider;

class NumberSampleProvider extends AbstractFormatterProvider
{
    public function asNumber($value)
    {
        return $this->normalise($value);
    }

    public function asUnsigned($value)
    {
        $value = $this->normalise($value);
        if ($value < 0) {
            $value *= -1;
        }

        return $value;
    }

    private function normalise($value)
    {
        if (!is_numeric($value)) {
            $value = 0;
        }

        return (float)$value;
    }

}
