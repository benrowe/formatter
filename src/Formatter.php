<?php

namespace Benrowe\Formatter;

use \ReflectionObject;
use \ReflectionMethod;
use InvalidArgumentException;

/**
 * Formatter
 * Enables values to be formatted
 *
 * @package Benrowe\Formatter
 */
class Formatter extends AbstractFormatterProvider
{
    /**
     * If no formatter is specified, this formatter is used by default
     *
     * @var string
     */
    protected $defaultFormatter;

    /**
     * The list of available formatters.
     * The key is the same key that is exposed in the format() method
     * The value is either a Closure, a FQC, or an object that implements the
     * FormatterProvider interface
     *
     * @var array
     */
    private $formatters = [];

    private $formatMethodPrefix = 'as';

    public $nullValue = '<span>Not Set</span>';

    /**
     * Constructor
     *
     * @param array $formatters The formatters to provide, either as instances
     *                          of FormatterProvider or closures
     */
    public function __construct($formatters = [])
    {
        foreach ($formatters as $formatter => $closure) {
            $this->addFormatter($formatter, $closure);
        }
    }

    /**
     * Set the default formatter to use
     *
     * @param string $format
     */
    public function setDefaultFormatter($format)
    {
        if (!$this->hasFormat($format)) {
            throw new InvalidArgumentException(
                'format "'.$format.'" does not exist'
            );
        }
        $this->defaultFormatter = $format;
    }

    /**
     * Get the default formatter
     *
     * @return string
     */
    public function getDefaultFormatter()
    {
        return $this->defaultFormatter;
    }

    /**
     * Add a new or replace a formatter within the stack
     *
     * @param string $name   The name of the formatter
     * @param \Closure\FormatterProvider $method the object executes the format
     */
    public function addFormatter($name, $method)
    {
        if (!preg_match("/^[\w]+$/", $name)) {
            throw new InvalidArgumentException(
                'Supplied formatter name "'.$name.'" contains invalid characters'
            );
        }
        if (!($method instanceof FormatterProvider || $method instanceof \Closure)) {
            throw new InvalidArgumentException('Supplied formatter is not supported');
        }
        $this->formatters[$name] = $method;
        if (!$this->defaultFormatter) {
            $this->setDefaultFormatter($name);
        }
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

        list($format, $params) = $this->extractFormatAndParams($value, $format);

        if (!$this->hasFormat($format)) {
            throw new InvalidArgumentException(
                'Unknown format: "' . $format . '"'
            );
        }

        // is the formatter in a custom defined

        $callback = $this->formatters[$format];

        if ($callback instanceof \Closure) {
            $func = $callback->bindTo($this);
        } else if (method_exists($this, $callback)) {
            $func = [$this, $callback];
        }

        return call_user_func_array($func, $params);
    }

    /**
     * Get the current list of provided formatters
     *
     * @return array
     */
    public function formats()
    {
        return array_keys($this->formatters);
    }

    /**
     * Allow dynamic calls to be made to the formatter
     *
     * @todo Is this still needed?
     */
    public function __call($method, $params)
    {
        $format = strtolower(substr($method, strlen($this->formatMethodPrefix)));
        $value = array_shift($params);
        array_unshift($params, $format);
        return $this->format($value, $params);
    }

    /**
     * Determine if the format exists within the formatter.
     *
     * @return boolean
     */
    public function hasFormat($format)
    {
        return array_key_exists(strtolower($format), $this->formatters);
    }
}
