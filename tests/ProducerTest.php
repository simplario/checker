<?php

namespace Simplario\Checker\Tests;

use Simplario\Checker\Producer;
use Simplario\Checker\Checker\AbstractChecker;
use Simplario\Checker\Output\AbstractOutput;
use Simplario\Checker\Output\Stack;
use Simplario\Checker\ResultException\ErrorException;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;
use PHPUnit\Framework\TestCase;

class ProducerTest extends TestCase
{
    public function testInstance()
    {
        $config = ['tasks' => []];

        $checker = new Producer($config);

        $this->assertInstanceOf(Producer::class, $checker);
    }


    public function testGetSetOutput()
    {
        $checker = new Producer();
        $output = $checker->getOutput();
        $this->assertInstanceOf(AbstractOutput::class, $output);


        $checker = new Producer();
        $stack = new Stack();
        $checker->setOutput($stack);
        $output = $checker->getOutput();
        $this->assertInstanceOf(AbstractOutput::class, $output);
        $this->assertEquals($stack, $output);
    }


    public function testCreateChecker()
    {
        $stack = new Stack();
        $checker = new Producer();
        $checker->setOutput($stack);

        $fs1 = $checker->createChecker('filesystem');
        $fs2 = $checker->createChecker('filesystem');

        $this->assertInstanceOf(AbstractChecker::class, $fs1);
        $this->assertEquals($fs1, $fs2);
    }


    public function testRunEmptyConfig()
    {
        $config = ['tasks' => []];

        $stack = new Stack();
        $checker = new Producer();
        $checker->setOutput($stack);
        $checker->run();

        $output = $stack->getStack();
        $this->assertEquals($output[0]['message'], Producer::ERROR_CONFIG_WITH_EMPTY_TASK);
        $this->assertEquals($output[0]['type'], Stack::TYPE_ERROR);
    }


    public function testRunTaskOneByOne()
    {
        $config = ['tasks' => []];
        $stack = new Stack();
        $checker = new Producer();
        $checker->setOutput($stack);

        $resultException = $checker->runTask([]);
        $this->assertInstanceOf(ErrorException::class, $resultException);


        $resultException = $checker->runTask(['checker' => 'filesystem', 'path' => __FILE__, 'exists' => true]);
        $this->assertInstanceOf(SuccessException::class, $resultException);

        $resultException = $checker->runTask(['checker' => 'filesystem', 'path' => __FILE__, 'exists' => false]);
        $this->assertInstanceOf(FailException::class, $resultException);

        $resultException = $checker->runTask(['checker' => 'filesystem', 'path' => __FILE__, 'UNDEFINED' => true]);
        $this->assertInstanceOf(ErrorException::class, $resultException);

    }


    public function testRunProducer()
    {
        $tasks = [
            ['checker' => 'filesystem', 'path' => __FILE__, 'exists' => true],
            ['checker' => 'filesystem', 'path' => __FILE__, 'exists' => false],
            ['checker' => 'filesystem', 'path' => __FILE__, 'UNDEFINED' => true]
        ];

        $stack = new Stack();
        $checker = new Producer($tasks);
        $checker->setOutput($stack);
        $checker->run();

        $output = json_encode($stack->getStack());

        $this->assertContains(Producer::PLACEHOLDER_TASK_SUCCESS, $output);
        $this->assertContains(Producer::PLACEHOLDER_TASK_FAIL, $output);
        $this->assertContains(Producer::PLACEHOLDER_TASK_ERROR, $output);
    }

}