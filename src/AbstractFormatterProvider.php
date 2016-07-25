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

    public $nullValue = '<span>Not Set</span>';

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
            $name = $this->getFormatterName($method);
            if ($name) {
                $formats[] = $name;
            }
        }

        return $formats;
    }

    /**
     * Get the name of the formatter method
     *
     * @param ReflectionMethod $method
     * @return string
     */
    private getFormatterName(ReflectionMethod $method)
    {
        preg_match(self::METHOD_PATTERN_MATCH, $method->getName(), $match);
        $isFormatter = !$method->isStatic() && $match;

        return $isFormatter ? strtolower($match[1]) : '';
    }

    /**
     * Combine the value & params
     * @param  mixed $value  the value (first argument of the format method)
     * @param  string|array $format the name of the formatter, or an array of
     *                              the formatter and its addtional params
     * @return array of two elements, format and the params for the formatter
     *                  method
     * @throws InvalidArgumentException if the format is incorrect
     */
    protected function extractFormatAndParams($value, $format)
    {
        $params = [$value];

        if (is_array($format)) {
            if (!isset($format[0])) {
                throw new InvalidArgumentException(
                    'The $format must contain at least one element'
                );
            }
            $params = $format;
            $format = array_shift($params);
            array_unshift($params, $value);
        }

        return [$format, $params];
    }

    /**
     * Format the supplied value, based on the desired format + configuration
     *
     * @param  mixed $value The value to format
     * @param  string|array|null $format either the formatter name, or the formatter
     *                              config as an array. If it's an array, the
     *                              first item must be the same of the formatter
     * @return mixed
     * @throws InvalidArgumentException if the format is incorrect
     */
    public function format($value, $format = null)
    {
        $format = $format ?: $this->defaultFormatter;

        list($format, $params) = $this->extractFormatAndParams($value, $format);

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
        if (!preg_match("/^[A-Za-z]+$/", $format)) {
            throw new InvalidArgumentException(
                'Format "' . $format . '" is not provided in correct format'
            );
        }
        $formats = $this->formats();

        return in_array($format, $formats);
    }
}
