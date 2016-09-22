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
    /**
     * Format the value as a html link
     *
     * @param  string $value link
     * @return string
     */
    public function asLink($value)
    {
        if ($value === null) {
            return $this->nullValue;
        }
        return '<a href="'.$value.'">'.$value.'</a>';
    }

    /**
     * Format the value as a html image
     *
     * @param  string $value image url
     * @return string
     */
    public function asImage($value)
    {
        if ($value === null) {
            return $this->nullValue;
        }

        return '<img src="'.$value.'">';
    }
}
