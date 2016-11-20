<?php

namespace Simplario\Checker\Output;

abstract class AbstractOutput
{

    const TYPE_DEFAULT = 'default';
    const TYPE_SUCCESS = 'success';
    const TYPE_FAIL = 'fail';
    const TYPE_ERROR = 'error';

    abstract public function write($msg = '', $type = self::TYPE_DEFAULT);
}
