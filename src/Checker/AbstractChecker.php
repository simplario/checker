<?php

namespace Simplario\Checker\Checker;

use Simplario\Checker\ResultException\ErrorException;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;

/**
 * Class AbstractChecker
 *
 * @package Simplario\Checker\Checker
 */
abstract class AbstractChecker
{
    /**
     * @var array
     */
    protected $ignoreTaskKeys = [];

    /**
     * @var string
     */
    protected $target = 'target';

    /**
     * @param array $task
     *
     * @throws ErrorException
     * @throws SuccessException
     */
    public function check(array $task)
    {
        foreach ($task as $test => $options) {

            if ($test === 'checker' || $test === $this->target || in_array($test, $this->ignoreTaskKeys, true)) {
                continue;
            }

            $method = 'test' . ucfirst($test);
            $this->tryMethod($method, $task, $options);
        }

        // final success
        throw new SuccessException("Ok", $task);
    }

    /**
     * @param string $method
     * @param array  $task
     * @param mixed  $options
     *
     * @return $this
     * @throws ErrorException
     */
    protected function tryMethod($method, array $task, $options)
    {
        if (!method_exists($this, $method)) {
            throw new ErrorException("Test method not exists '{$method}'", $task);
        }

        try {
            // if test success - throw SuccessException
            // if test fail - throw FailException
            // if test error - ErrorException
            call_user_func_array([$this, $method], [$task[$this->target], $options, $task]);
        } catch (SuccessException $ex) {
            // - test success
        }

        return $this;
    }
}
