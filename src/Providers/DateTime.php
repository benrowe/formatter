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
    protected $carbon;

    public function __construct(Carbon $carbon)
    {
        $this->carbon = $carbon;
    }

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

    private $durationUnits = [
        'Day'    => 86400,
        'Hour'   => 3600,
        'Minute' => 60,
        'Second' => 1
    ];

    /**
     * Take in a number of seconds and display that as a human readable amount
     * of time
     *
     * From: https://jonlabelle.com/snippets/view/php/convert-seconds-to-human-readable
     *
     * @param  int $seconds
     * @return string
     * @todo allow units to be overridden (non-english..)
     */
    public function asDurationHuman($seconds, $delimit = ', ')
    {
        if ($seconds === null) {
            return $this->nullValue;
        }

        $parts = [];

        foreach ($this->durationUnits as $label => $duration) {
            $div = floor($seconds / $duration);
            if ($div == 0) {
                continue;
            }

            $part = $div . ' ' . $label;
            if ($div != 1) {
                $part .= 's';
            }
            $parts[] = $part;

            $seconds %= $duration;
        }

        $last = array_pop($parts);

        if (empty($parts)) {
            return $last;
        }

        return join($delimit, $parts) . ' and ' . $last;
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
        return $this->carbon;
    }
}
