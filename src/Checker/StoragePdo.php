<?php

namespace Simplario\Checker\Checker;

use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;

class StoragePdo extends AbstractChecker
{

    protected $target = 'connect';

    protected function createInstance(array $connect)
    {
        // Exception on fail connection
        $pdo = new \PDO($connect['dsn'], $connect['user'], $connect['password']);

        return $pdo;
    }

    protected function testExists($connect, $expectExists, array $task)
    {
        $exists = true;
        $msg = 'Connection exists';

        try {
            $pdo = $this->createInstance($connect);
        } catch (\Exception $ex) {
            $exists = false;
            $msg = $ex->getMessage();
        }

        if ($exists === $expectExists) {
            throw new SuccessException('Ok', $task);
        }

        throw new FailException($msg, $task);
    }


}
