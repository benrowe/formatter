<?php

namespace Benrowe\Formatter;

use ReflectionClass;
use ReflectionMethod;

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
    /**
     * method prefix
     */
    const METHOD_PATTERN_MATCH = '/^as([A-Z]\w+)$/';

    /**
     * Provide a list of formatters this class makes available
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

    public function format($value, array $params = [])
    {

    }
}
