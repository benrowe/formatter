<?php

namespace Benrowe\Formatter;

use \ReflectionObject;
use \ReflectionMethod;
use \Closure;
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
     * The list of available formatter providers.
     * The key is the same key that is exposed in the format() method
     * The value is either a Closure, a FQC, or an object that implements the
     * FormatterProvider interface
     *
     * @var array list of formatters & providers|closures
     */
    private $providers = [];

    /**
     * A list of all the available formats. If a formatter is an instance of
     * FormatterProvider, it's list is exploded using dot notiation.
     *
     * @var string[]
     */
    private $formats = [];

    private $formatMethodPrefix = 'as';

    /**
     * Constructor
     *
     * @param array $formatters The formatters to provide, either as instances
     *                          of FormatterProvider or closures
     */
    public function __construct(array $formatters = [])
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
     * @param Closure|FormatterProvider $method the object executes the format
     * @throws InvalidArgumentException
     */
    public function addFormatter($name, $method)
    {
        $this->validateProviderName($name);
        $method = $this->getFormatterObject($method);

        if (!($method instanceof FormatterProvider || $method instanceof Closure)) {
            throw new InvalidArgumentException('Supplied formatter is not supported');
        }
        $name = strtolower($name);
        $this->providers[$name] = $method;

        // generate a list of formats from this method
        $this->formats = array_merge(
            $this->formats,
            $this->getFormatsFromFormatter($method, $name)
        );

        $this->checkDefaultFormatter();
    }

    /**
     * Detect and convert the FQN of a formatter provider into an instance
     *
     * @param  FormatterProvider|Closure|string $formatter
     * @return FormatterProvider|Closure
     */
    private function getFormatterObject($formatter)
    {
        if (is_string($formatter) && class_exists($formatter)) {
            $formatter = new $formatter;
        }
        return $formatter;
    }

    /**
     * Check the default format and set the default if we have at least
     * one formatter
     *
     * @return nil
     */
    private function checkDefaultFormatter()
    {
        if (!$this->defaultFormatter) {
            $format = current($this->formats);
            if ($format) {
                $this->setDefaultFormatter($format);
            }
        }
    }

    /**
     * Get a list of available formats from the supplied formatter
     *
     * @param  Closure|FormatterProvider $formatter
     * @param  string $name Base name of the formatter
     * @return string[]
     */
    private function getFormatsFromFormatter($formatter, $name)
    {
        if ($formatter instanceof Closure) {
            return [$name];
        }
        $formats = $formatter->formats();
        // prefix each formatter of the object with the name of the formatter
        return array_map(function ($value) use ($name) {
            return $name . '.' . $value;
        }, $formats);
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

        return $this->callFormatter($format, $params);
    }

    /**
     * Get the current list of available formats
     *
     * @return array
     */
    public function formats()
    {
        return $this->formats;
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
     * @throws InvalidArgumentException
     */
    public function hasFormat($format)
    {
        if (!preg_match("/^[A-Za-z]+(\.[A-Za-z]+)?$/", $format)) {
            throw new InvalidArgumentException(
                'Format "' . $format . '" is not provided in correct format'
            );
        }
        return in_array(strtolower($format), $this->formats);
    }

    /**
     * Validate the provider name
     *
     * @param  string $name
     * @return boolean
     */
    private function validateProviderName($name)
    {
        if (!preg_match("/^[\w]+$/", $name)) {
            throw new InvalidArgumentException(
                'Supplied formatter name "'.$name.'" contains invalid characters'
            );
        }
        return true;
    }

    /**
     * Calls the requested formatting method based on it's simple formatting name
     * + passes through the requested params
     *
     * @param  string $format
     * @param  array  $params the first is the value
     * @return mixed
     */
    private function callFormatter($format, array $params)
    {
        // is the formatter in a custom defined
        if (strpos($format, '.') > 0) {
            // provider
            list($provider, $format) = explode('.', $format, 2);

            $callback = $this->providers[$provider];
            $func = [$callback, 'format'];

            // extract the value from the params
            $value = array_shift($params);

            // push the format to the front of the params
            array_unshift($params, $format);
            $params = [$value, $params];
        } else {
            // Closure
            $callback = $this->providers[$format];
            $func = $callback->bindTo($this);
        }

        return call_user_func_array($func, $params);
    }
}
