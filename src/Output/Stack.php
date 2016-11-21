<?php

namespace Simplario\Checker\Output;

/**
 * Class Stack
 *
 * @package Simplario\Checker\Output
 */
class Stack extends AbstractOutput
{
    /**
     * @var array
     */
    protected $stack = [];

    /**
     * @param string $msg
     * @param string $type
     *
     * @return $this
     */
    public function write($msg = '', $type = self::TYPE_DEFAULT)
    {
        $this->stack[] = [
            'message' => $msg,
            'type'    => $type,
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getStack()
    {
        return $this->stack;
    }
}
