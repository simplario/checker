<?php

namespace Simplario\Checker\Checker;

use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;

class Service extends AbstractChecker
{

    protected $target = 'name';


    protected function runCommand($command)
    {
        $output = '';
        $process = popen($command, 'r');
        while (!feof($process)) {
            $t = fread($process, 4096);
            $output .= $t;
        }
        pclose($process);

        $output = strtr($output, ["\n" => ' ', "\r" => ' ', "\t" => ' ']);
        $output = trim($output);

        return $output;
    }

    protected function testExists($name, $expectExists, array $task)
    {
        $output = $this->runCommand("which {$name}");

        if (!empty($output) === $expectExists) {
            throw new SuccessException('Ok', $task);
        }

        $msg = $expectExists ? "Service '{$name}' is not exists'" : "Service '{$name}' is exists";

        throw new FailException($msg, $task);
    }

    protected function testWhich($name, $expectWhich, array $task)
    {
        $output = $this->runCommand("which {$name}");

        if ($output === $expectWhich) {
            throw new SuccessException('Ok', $task);
        }

        $msg = "Service '{$name}' expected: '{$expectWhich}', but have {$output}";

        throw new FailException($msg, $task);
    }

    protected function testVersion($name, $version, array $task)
    {
        $output = $this->runCommand("{$name} -version");

        $pattern = "/{$version}/i";

        if (preg_match($pattern, $output)) {
            throw new SuccessException('Ok', $task);
        }

        $msg = "Service '{$name}' version fail '{$version}'";

        throw new FailException($msg, $task);
    }
}
