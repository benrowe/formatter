<?php

namespace Benrowe\Formatter\Providers;

use Benrowe\Formatter\AbstractFormatterProvider;

/**
 * Provides formatters related to computer related data such as filesizes
 *
 * @package Benrowe\Formatter
 */
class Computer extends AbstractFormatterProvider
{
    private $fileUnits = [
        'B', 'kB', 'Mb', 'Gb', 'Tb'
    ];

    /**
     * Express the size of a file (as bytes) as a human readable.
     * The value is returned as the most appropriate size
     *
     * @param  int $bytes
     * @return string
     */
    public function asFilesize($bytes)
    {
        if ($bytes === null) {
            return $this->nullValue;
        }

        $bytes = (int)$bytes;
        if ($bytes < 0) {
            $bytes = 0;
        }

        $factor = floor(strlen($bytes - 1) / 3);
        $decimals = 2;

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $this->fileUnits[$factor];
    }
}
