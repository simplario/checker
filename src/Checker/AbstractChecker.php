<?php

namespace Simplario\Checker\Checker;

use Simplario\Checker\ResultException\ErrorException;
use Simplario\Checker\ResultException\SuccessException;

abstract class AbstractChecker
{

    protected $ignoreTaskKeys = [];
    protected $target = 'target';

    public function check(array $task)
    {
        foreach ($task as $test => $options) {

            if ($test === 'checker' || $test === $this->target || in_array($test, $this->ignoreTaskKeys, true)) {
                continue;
            }

            $method = 'test' . ucfirst($test);
            if (method_exists($this, $method)) {
                // TODO: if success - we will have exception - WTF !!!!
                try {
                    call_user_func_array([$this, $method], [$task[$this->target], $options, $task]);
                } catch (SuccessException $ex) {
                    // nothing to do
                }

                continue;
            }

            throw new ErrorException("Test method not exists '{$method}'", $task);
        }

        // final success
        throw new SuccessException("Ok", $task);
    }
}
