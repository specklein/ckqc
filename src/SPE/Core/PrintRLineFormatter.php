<?php

namespace SPE\Core;

use Monolog\Logger;
use Monolog\Formatter\LineFormatter;

class PrintRLineFormatter extends LineFormatter 
{
    /**
     * {@inheritdoc}
     */
    public function format(array $record) {
        return $record['datetime']->format($this->dateFormat)." ".print_r($record['message'],true).PHP_EOL;

    }
}

