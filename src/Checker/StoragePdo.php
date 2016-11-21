<?php

namespace Simplario\Checker\Checker;

use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;

/**
 * Class StoragePdo
 *
 * @package Simplario\Checker\Checker
 */
class StoragePdo extends AbstractChecker
{
    /**
     * @var string
     */
    protected $target = 'connect';

    /**
     * @param array $connect
     *
     * @return \PDO
     */
    protected function createInstance(array $connect)
    {
        // Exception on fail connection
        $instance = new \PDO(
            isset($connect['dsn']) ? $connect['user'] : null,
            isset($connect['user']) ? $connect['user'] : null,
            isset($connect['password']) ? $connect['password'] : null,
            isset($connect['options']) ? $connect['options'] : null
        );

        return $instance;
    }

    /**
     * @param array   $connect
     * @param boolean $expectExists
     * @param array   $task
     *
     * @throws FailException
     * @throws SuccessException
     */
    protected function testExists(array $connect, $expectExists, array $task)
    {
        $exists = true;
        $msg = 'Connection exists';

        try {
            $pdo = $this->createInstance($connect);
        } catch (\Exception $ex) {
            $exists = false;
            $msg = "Unable to connect to database. " . $ex->getMessage();
        }

        if ($exists === $expectExists) {
            throw new SuccessException('Ok', $task);
        }

        throw new FailException($msg, $task);
    }
}
