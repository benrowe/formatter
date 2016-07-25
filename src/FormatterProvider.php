<?php

namespace Benrowe\Formatter;

/**
 * Formatter Provider interface
 *
 * Provide a standard format interface for Providers to adher to
 *
 * @package Benrowe\Formatter
 */
interface FormatterProvider
{
    /**
     * Describes the formats that this formatter provides
     *
     * @return string[]
     */
    public function formats();

    /**
     * Checks if the format exists
     *
     * @param  string  $format
     * @return boolean
     */
    public function hasFormat($format);

    /**
     * Format the corresponding value to the format provided
     *
     * @param  mixed $value
     * @param  string|array|null $format either the format as a string, or an array,
     *                              where the first element is the format type
     * @return mixed
     */
    public function format($value, $format = null);
}
