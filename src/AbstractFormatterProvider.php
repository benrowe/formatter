<?php

namespace Benrowe\Formatter;

use ReflectionClass;
use ReflectionMethod;
use InvalidArgumentException;

/**
 * AbstractFormatterProvider
 *
 * Base level functionality for any FormatterProvider that wants to implement
 * the standard formatting convention of `public function asFormatType($value)`
 *
 * @package Benrowe\Formatter
 */
abstract class AbstractFormatterProvider implements FormatterProvider
{
    protected $defaultFormatter;
    /**
     * method prefix
     */
    const METHOD_PATTERN_MATCH = '/^as([A-Z]\w+)$/';

    /**
     * Provide a list of formatters this that are available from this provider
     *
     * @return array
     */
    public function formats()
    {
        // get a list of all public non-static methods that start with
        // METHOD_PREFIX
        $reflect = new ReflectionClass($this);
        $formats = [];
        foreach ($reflect->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $isFormatter =
                !$method->isStatic() &&
                preg_match(self::METHOD_PATTERN_MATCH, $method->getName(), $match);
            if (!$isFormatter) {
                continue;
            }
            $formats[] = strtolower($match[1]);
        }

        return $formats;
    }

    /**
     * Format the supplied value, based on the desired format + configuration
     *
     * @param  mixed $value The value to format
     * @param  string|array $format either the formatter name, or the formatter
     *                              config as an array. If it's an array, the
     *                              first item must be the same of the formatter
     * @return mixed
     */
    public function format($value, $format = null)
    {
        $format = $format ?: $this->defaultFormatter;

        $params = [$value];

        if (is_array($format)) {
            if (!isset($format[0])) {
                throw new InvalidArgumentException(
                    'The $format must contain at least one element'
                );
            }
            $tmpFormat = $format[0];
            $format[0] = $value;
            $params = $format;
            $format = $tmpFormat;
        }

        if (!$this->hasFormat($format)) {
            throw new InvalidArgumentException(
                'Unknown format: "' . $format . '"'
            );
        }

        // is the formatter in a custom defined

        $func = [$this, 'as'.$format];

        return call_user_func_array($func, $params);
    }

    /**
     * Check if the requested format exists in this provider
     *
     * @param  string  $format The formatter name you want to check for
     * @return boolean
     */
    public function hasFormat($format)
    {
        $formats = $this->formats();

        return in_array($format, $formats);
    }
}
