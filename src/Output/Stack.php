<?php

namespace Simplario\Checker\Output;


class Stack extends AbstractOutput
{

    protected $stack = [];

    public function write($msg = '', $type = self::TYPE_DEFAULT)
    {
        $this->stack[] = [
            'message' => $msg,
            'type'    => $type,
        ];

        return $this;
    }

    public function getStack()
    {
        return $this->stack;
    }

}
