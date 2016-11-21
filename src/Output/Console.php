<?php

namespace Simplario\Checker\Output;

/**
 * Class Console
 *
 * @package Simplario\Checker\Output
 */
class Console extends AbstractOutput
{
    /**
     * @param string $msg
     * @param string $type
     *
     * @return $this
     */
    public function write($msg = '', $type = self::TYPE_DEFAULT)
    {
        echo $msg . PHP_EOL;

        return $this;
    }
}
