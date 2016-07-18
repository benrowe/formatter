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
     * Format the corresponding value to the format provided
     *
     * @param  mixed $value
     * @param  array $params
     * @return mixed
     */
    public function format($value, array $params = []);
}
