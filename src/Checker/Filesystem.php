<?php

namespace Simplario\Checker\Checker;

use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;

/**
 * Class Filesystem
 *
 * @package Simplario\Checker\Checker
 */
class Filesystem extends AbstractChecker
{
    /**
     * @var string
     */
    protected $target = 'path';

    /**
     * @param string  $path
     * @param boolean $expectExists
     * @param array   $task
     *
     * @throws FailException
     * @throws SuccessException
     */
    protected function testExists($path, $expectExists, array $task)
    {
        $exists = is_file($path) || is_dir($path);

        if ($exists === $expectExists) {
            throw new SuccessException('Ok', $task);
        }

        $msg = $expectExists ? "Path '{$path}' is not exists'" : "Path '{$path}' is exists";

        throw new FailException($msg, $task);
    }

    /**
     * @param string  $path
     * @param boolean $expectFile
     * @param array   $task
     *
     * @throws FailException
     * @throws SuccessException
     */
    protected function testFile($path, $expectFile, array $task)
    {
        if (is_file($path) === $expectFile) {
            throw new SuccessException('Ok', $task);
        }

        $msg = $expectFile ? "Path '{$path}' is not a file'" : "Path '{$path}' is a file";

        throw new FailException($msg, $task);
    }

    /**
     * @param string  $path
     * @param boolean $expectFolder
     * @param array   $task
     *
     * @throws FailException
     * @throws SuccessException
     */
    protected function testFolder($path, $expectFolder, array $task)
    {
        if (is_dir($path) === $expectFolder) {
            throw new SuccessException('Ok', $task);
        }

        $msg = $expectFolder ? "Path '{$path}' is not a folder'" : "Path '{$path}' is a folder";

        throw new FailException($msg, $task);
    }

    /**
     * @param string  $path
     * @param boolean $expectWritable
     * @param array   $task
     *
     * @throws FailException
     * @throws SuccessException
     */
    protected function testWritable($path, $expectWritable, array $task)
    {
        if (is_writeable($path) === $expectWritable) {
            throw new SuccessException('Ok', $task);
        }

        $msg = $expectWritable ? "Path '{$path}' is not writable'" : "Path '{$path}' is writable";

        throw new FailException($msg, $task);
    }

    /**
     * @param string  $path
     * @param boolean $expectReadable
     * @param array   $task
     *
     * @throws FailException
     * @throws SuccessException
     */
    protected function testReadable($path, $expectReadable, array $task)
    {
        if (is_readable($path) === $expectReadable) {
            throw new SuccessException('Ok', $task);
        }

        $msg = $expectReadable ? "Path '{$path}' is not readable'" : "Path '{$path}' is readable";

        throw new FailException($msg, $task);
    }

    /**
     * @param string  $path
     * @param boolean $expectChmod
     * @param array   $task
     *
     * @throws FailException
     * @throws SuccessException
     */
    protected function testChmod($path, $expectChmod, array $task)
    {
        $chmod = substr(sprintf('%o', fileperms($path)), -4);

        if ($chmod === $expectChmod) {
            throw new SuccessException('Ok', $task);
        }

        $msg = "Path '{$path}' chmod expected: '{$expectChmod}', but have: '{$chmod}'";

        throw new FailException($msg, $task);
    }
}
