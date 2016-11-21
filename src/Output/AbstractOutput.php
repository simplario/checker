<?php

namespace Simplario\Checker\Output;

/**
 * Class AbstractOutput
 *
 * @package Simplario\Checker\Output
 */
abstract class AbstractOutput
{

    const TYPE_DEFAULT = 'default';
    const TYPE_SUCCESS = 'success';
    const TYPE_FAIL = 'fail';
    const TYPE_ERROR = 'error';

    /**
     * @param string $msg
     * @param string $type
     *
     * @return mixed
     */
    abstract public function write($msg = '', $type = self::TYPE_DEFAULT);
}
