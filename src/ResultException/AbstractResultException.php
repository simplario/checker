<?php

namespace Simplario\Checker\ResultException;


abstract class AbstractResultException extends \Exception
{

    protected $task;

    public function __construct($msg, array $task)
    {
        $this->message = $msg;
        $this->task = $task;
    }

    public function getTask()
    {
        return $this->task;
    }

    public function getChecker()
    {
        return $this->task['checker'];
    }

    public function getJson()
    {
        return json_encode($this->task);
    }
}