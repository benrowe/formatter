<?php

namespace Benrowe\Formatter\Providers;

use Benrowe\Formatter\AbstractFormatterProvider;

/**
 * Provides formatters that produce specific html based output
 *
 * @package Benrowe\Formatter
 */
class Html extends AbstractFormatterProvider
{
    public function asLink($value)
    {
        if ($value === null) {
            return $this->nullValue;
        }
        return '<a href="'.$value.'">'.$value.'</a>';
    }

    public function asImage($value)
    {
        if ($value === null) {
            return $this->nullValue;
        }

        return '<img src="'.$value.'">';
    }
}
