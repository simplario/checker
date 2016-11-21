<?php

namespace Simplario\Checker\Checker;

use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;

/**
 * Class PhpExtension
 *
 * @package Simplario\Checker\Checker
 */
class PhpExtension extends AbstractChecker
{

    /**
     * @var string
     */
    protected $target = 'extension';

    /**
     * @param string  $name
     * @param boolean $expectExists
     * @param array   $task
     *
     * @throws FailException
     * @throws SuccessException
     */
    protected function testExists($name, $expectExists, array $task)
    {
        if (extension_loaded($name) === $expectExists) {
            throw new SuccessException('Ok', $task);
        }

        $msg = $expectExists ? "Php extension'{$name}' is not loaded'" : "Php extension '{$name}' is loaded";

        throw new FailException($msg, $task);
    }
}
