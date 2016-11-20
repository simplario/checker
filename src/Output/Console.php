<?php

namespace Simplario\Checker\Output;


class Console extends AbstractOutput
{

    public function write($msg = '', $type = self::TYPE_DEFAULT)
    {
        echo $msg . PHP_EOL;

        return $this;
    }
}
