<?php

namespace Simplario\Checker\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class RunnerTest
 *
 * @package Simplario\Checker\Tests
 */
class RunnerTest extends TestCase
{
    /**
     * @var string
     */
    protected $onSuccessOutput = __DIR__ . '/../on-success.txt';

    /**
     * @return void
     */
    public function testRunnerConfigPhp()
    {
        $output = '';
        exec('./checker example/checker-success.php', $output);
        $this->assertContains(file_get_contents($this->onSuccessOutput), implode(PHP_EOL, $output));
    }

    /**
     * @return void
     */
    public function testRunnerConfigYaml()
    {
        $output = '';
        exec('./checker example/checker-success.yaml', $output);
        $this->assertContains(file_get_contents($this->onSuccessOutput), implode(PHP_EOL, $output));
    }

    /**
     * @return void
     */
    public function testRunnerConfigJson()
    {
        $output = '';
        exec('./checker example/checker-success.json', $output);
        $this->assertContains(file_get_contents($this->onSuccessOutput), implode(PHP_EOL, $output));
    }
}