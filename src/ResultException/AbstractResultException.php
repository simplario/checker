<?php

namespace Simplario\Checker\ResultException;

/**
 * Class AbstractResultException
 *
 * @package Simplario\Checker\ResultException
 */
abstract class AbstractResultException extends \Exception
{
    /**
     * @var array
     */
    protected $task;

    /**
     * AbstractResultException constructor.
     *
     * @param string $msg
     * @param array  $task
     */
    public function __construct($msg, array $task)
    {
        $this->message = $msg;
        $this->task = $task;
    }

    /**
     * @return array
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return string
     */
    public function getChecker()
    {
        return $this->task['checker'];
    }

    /**
     * @return string
     */
    public function getJson()
    {
        return json_encode($this->task);
    }
}
