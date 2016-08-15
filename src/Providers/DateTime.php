<?php

namespace Benrowe\Formatter\Providers;

use Benrowe\Formatter\AbstractFormatterProvider;
use Carbon\Carbon;
use Carbon\CarbonInterval;

/**
 * DateTime Formatter
 *
 * Contains formatter for datetime values
 *
 * @package Benrowe\Formatter
 */
class DateTime extends AbstractFormatterProvider
{
    /**
     * Format the datetime as a date
     *
     * @param  mixed $value
     * @param  string $format
     * @return string
     */
    public function asDate($value, $format = 'Y-m-d')
    {
        return $this->output($value, $format);
    }

    /**
     * Format the datetime as a date
     *
     * @param  mixed $value
     * @param  string $format
     * @return string
     */
    public function asTime($value, $format = 'H:i:s')
    {
        return $this->output($value, $format);
    }

    /**
     * Format the datetime as a date
     *
     * @param  mixed $value
     * @param  string $format
     * @return string
     */
    public function asDateTime($value, $format = 'Y-m-d H:i:s')
    {
        return $this->output($value, $format);
    }

    /**
     * Take in a number of seconds and display that as a human readable amount of time
     *
     * @param  int $value
     * @return string
     */
    public function asHuman($value)
    {
        $int = CarbonInterval::seconds($value);
    }

    /**
     * Generate the output from the value
     *
     * @param  mixed $value the datetime value
     * @param  string $format format string
     * @return string
     */
    private function output($value, $format)
    {
        return $this
            ->normaliseValue($value)
            ->format($format);
    }

    /**
     * Convert the datetime input into a instance of Carbon
     *
     * @param  mixed $value the datetime value
     * @return Carbon
     */
    private function normaliseValue($value)
    {
        $carbon = $this->getCarbon();
        // sniff the value type
        if (is_int($value)) {
            return $carbon->createFromTimestamp($value);
        }
        return $carbon->parse($value);
    }

    /**
     * Get an instance of the carbon datetime handler
     *
     * @return Carbon
     * @throws FormatterException if carbon isn't available
     */
    private function getCarbon()
    {
        if (!class_exists('Carbon\Carbon')) {
            throw new FormatterException(
                'Unable to load the nesbot/carbon dependency.'
            );
        }
        return new Carbon;
    }
}
