<?php

namespace Benrowe\Formatter;

use \ReflectionClass;
use \ReflectionMethod;
use InvalidArgumentException;

/**
 *
 *
 * @package Benrowe\Formatter
 */
class Formatter
{
    private $defaultFormatter = 'raw';
    private $formatters = [];
    private $formatMethodPrefix = 'as';

    public $nullValue = '<span>Not Set</span>';

    /**
     * @param array $formatters specif
     */
    public function __construct($formatters = [])
    {
        $localFormatters = $this->getLocalFormats();
        $this->formatters = $formatters = array_merge($localFormatters, $formatters);
    }

    /**
     * Format the provided value based on the requested formatter
     *
     * @param mixed $value The value to format
     * @param string|array The format + format options, if an array is provided the first value is the formatter
     *                     and the other values are format params
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function format($value, $format = null)
    {
        $format = $format ?: $this->defaultFormatter;

        $params = [$value];

        if (is_array($format)) {
            if (!isset($format[0])) {
                throw new InvalidArgumentException('The $format must contain at least one element');
            }
            $tmpFormat = $format[0];
            $format[0] = $value;
            $params = $format;
            $format = $tmpFormat;

            if (!$this->hasFormat($format)) {
                throw new InvalidArgumentException('Unknown format: ' . $format);
            }
        }

        $func = [$this, 'as'.ucfirst($format)];
        if (!method_exists($this, $func[1])) {
            $func = $this->formatters[$format];
        }

        return call_user_func_array($func, $params);
    }

    /**
     * Get a list of the localy available formats
     * These are defined as formats as defined as public 'asFormat'
     * within this class
     *
     * @return array where the key is the format, and the
     *                     value is a reference to the callback
     */
    public function getLocalFormats()
    {
        $class   = new ReflectionClass($this);
        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $prefix  = $this->formatMethodPrefix;

        $formatMethods = array_filter($methods, function($method) use ($prefix) {
            return strpos($method->name, $prefix) === 0;
        });

        return array_map(function($method) {
            return strtolower(substr($method->name, strlen($this->formatMethodPrefix)));
        }, $formatMethods);
    }

    /**
     * Format the value as is, with the only acception being null values
     *
     * @param mixed $value the value to be formatted
     * @return mixed the formatted value
     */
    public function asRaw($value)
    {
        if ($value === null) {
            return $this->nullValue;
        }
        return $value;
    }

    /**
     * Allow for dynamic
     */
    public function __call($method, $params)
    {

    }

    /**
     * Determine if the format exists within the formatter.
     *
     * @return boolean
     */
    private function hasFormat($format)
    {
        return array_key_exists($format, $this->formatters);
    }
}
