<?php

namespace Simplario\Checker\Checker;

use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;

class PhpExtension extends AbstractChecker
{

    protected $target = 'extension';

    protected function testExists($name, $expectExists, array $task)
    {
        if (extension_loaded($name) === $expectExists) {
            throw new SuccessException('Ok', $task);
        }

        $msg = $expectExists ? "Php extension'{$name}' is not loaded'" : "Php extension '{$name}' is loaded";

        throw new FailException($msg, $task);
    }
}
