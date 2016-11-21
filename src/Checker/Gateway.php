<?php

namespace Simplario\Checker\Checker;

use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;

/**
 * Class Gateway
 *
 * @package Simplario\Checker\Checker
 */
class Gateway extends AbstractChecker
{
    /**
     * @var string
     */
    protected $target = 'url';

    /**
     * @param string $target
     * @param array  $options
     *
     * @return boolean
     */
    protected function curl($target, array $options = [])
    {
        $success = true;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!curl_exec($ch)) {
            $success = false;
        }
        curl_close($ch);

        return $success;
    }

    /**
     * @param string  $target
     * @param boolean $expectExists
     * @param array   $task
     *
     * @throws FailException
     * @throws SuccessException
     */
    protected function testExists($target, $expectExists, array $task)
    {
        $success = $this->curl($target, []);

        if ($success === $expectExists) {
            throw new SuccessException('Ok', $task);
        }

        $msg = $expectExists ? "Target '{$target}' is not available'" : "Target '{$target}' is available";

        throw new FailException($msg, $task);
    }
}
