<?php

namespace Simplario\Checker\Tests;

use PHPUnit\Framework\TestCase;

class RunnerTest extends TestCase
{
    protected $onSuccessOutput = __DIR__ . '/../on-success.txt';

    public function testRunnerConfigPhp()
    {
        $output = '';
        exec('./checker example/checker-success.php', $output);
        $this->assertContains(file_get_contents($this->onSuccessOutput), implode(PHP_EOL, $output));
    }

    public function testRunnerConfigYaml()
    {
        $output = '';
        exec('./checker example/checker-success.yaml', $output);
        $this->assertContains(file_get_contents($this->onSuccessOutput), implode(PHP_EOL, $output));
    }

    public function testRunnerConfigJson()
    {
        $output = '';
        exec('./checker example/checker-success.json', $output);
        $this->assertContains(file_get_contents($this->onSuccessOutput), implode(PHP_EOL, $output));
    }
}