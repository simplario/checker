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

/**
 * Class ProducerTest
 *
 * @package Simplario\Checker\Tests
 */
class ProducerTest extends TestCase
{

    /**
     * @return void
     */
    public function testInstance()
    {
        $tasks = [];
        $producer = new Producer($tasks);

        $this->assertInstanceOf(Producer::class, $producer);
    }

    /**
     * @return void
     */
    public function testGetDefaultOutput()
    {
        $tasks = [];
        $producer = new Producer($tasks);

        $output = $producer->getOutputHandler();
        $this->assertInstanceOf(AbstractOutput::class, $output);
    }


    /**
     * @return void
     */
    public function testGetCustomOutput()
    {
        $tasks = [];
        $producer = new Producer($tasks);

        $stack = new Stack();
        $producer->setOutputHandler($stack);

        $output = $producer->getOutputHandler();
        $this->assertInstanceOf(AbstractOutput::class, $output);
        $this->assertEquals($stack, $output);
    }

    /**
     * @return void
     */
    public function testCreateChecker()
    {
        $tasks = [];
        $producer = new Producer($tasks);

        $stack = new Stack();
        $producer->setOutputHandler($stack);

        $fs1 = $producer->createChecker('filesystem');
        $fs2 = $producer->createChecker('filesystem');

        $this->assertInstanceOf(AbstractChecker::class, $fs1);
        $this->assertEquals($fs1, $fs2);
    }

    /**
     * @return void
     */
    public function testCreateCustomChecker()
    {
        $this->assertEquals(1,1);

        $tasks = [];
        $producer = new Producer($tasks);

        $stack = new Stack();
        $producer->setOutputHandler($stack);

        $checker = $producer->createChecker(\Simplario\Checker\Checker\Filesystem::class);

        $this->assertInstanceOf(AbstractChecker::class, $checker);
    }


    /**
     * @return void
     */
    public function testRunEmptyConfig()
    {
        $tasks = [];
        $producer = new Producer($tasks);

        $stack = new Stack();
        $producer->setOutputHandler($stack);

        $producer->run();

        $output = $stack->getStack();
        $this->assertEquals($output[0]['message'], Producer::ERROR_CONFIG_WITH_EMPTY_TASK);
        $this->assertEquals($output[0]['type'], Stack::TYPE_ERROR);
    }


    /**
     * @return void
     */
    public function testRunTaskOneByOne()
    {
        $tasks = [];
        $producer = new Producer($tasks);

        $stack = new Stack();
        $producer->setOutputHandler($stack);

        $resultException = $producer->runTask([]);
        $this->assertInstanceOf(ErrorException::class, $resultException);

        $resultException = $producer->runTask(['checker' => 'filesystem', 'path' => __FILE__, 'exists' => true]);
        $this->assertInstanceOf(SuccessException::class, $resultException);

        $resultException = $producer->runTask(['checker' => 'filesystem', 'path' => __FILE__, 'exists' => false]);
        $this->assertInstanceOf(FailException::class, $resultException);

        $resultException = $producer->runTask(['checker' => 'filesystem', 'path' => __FILE__, 'UNDEFINED' => true]);
        $this->assertInstanceOf(ErrorException::class, $resultException);

    }

    /**
     * @return void
     */
    public function testRunProducer()
    {
        $tasks = [
            ['checker' => 'filesystem', 'path' => __FILE__, 'exists' => true],
            ['checker' => 'filesystem', 'path' => __FILE__, 'exists' => false],
            ['checker' => 'filesystem', 'path' => __FILE__, 'UNDEFINED' => true]
        ];

        $producer = new Producer($tasks);

        $stack = new Stack();
        $producer->setOutputHandler($stack);

        $producer->run();

        $output = json_encode($stack->getStack());

        $this->assertContains(Producer::PLACEHOLDER_TASK_SUCCESS, $output);
        $this->assertContains(Producer::PLACEHOLDER_TASK_FAIL, $output);
        $this->assertContains(Producer::PLACEHOLDER_TASK_ERROR, $output);
    }
}
