<?php

namespace Benrowe\Formatter\Providers;

use Benrowe\Formatter\AbstractFormatterProvider;
use Carbon\Carbon;

/**
 * DateTime Formatter
 *
 * Contains formatter for datetime values
 *
 * @package Benrowe\Formatter
 */
class DateTime extends AbstractFormatterProvider
{
    public function asDate()
    {

    }

    public function asTime()
    {

    }

    public function asDateTime()
    {

    }

    private function getCarbon()
    {
        if (!class_exists('Carbon\Carbon')) {
            throw new FormatterException(
                'Unable to load the carbon dependency.'
            );
        }
        return new Carbon;
    }
}
