<?php

namespace Simplario\Checker\Tests\Checker;

use Simplario\Checker\Checker\Filesystem;
use Simplario\Checker\ResultException\AbstractResultException;
use Simplario\Checker\ResultException\ErrorException;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;
use PHPUnit\Framework\TestCase;

class ResultExceptionTest extends TestCase
{
    public function testResultExceptionInstance()
    {
        $task = ['checker' => 'aaa', 'extra' => 'bbb'];
        $json = json_encode($task);

        $success = new SuccessException('Ok', $task);
        $fail = new FailException('Fail', $task);
        $error = new ErrorException('Error', $task);

        $this->assertInstanceOf(AbstractResultException::class, $success);
        $this->assertInstanceOf(AbstractResultException::class, $fail);
        $this->assertInstanceOf(AbstractResultException::class, $error);

        $this->assertEquals('Ok', $success->getMessage());
        $this->assertEquals('Fail', $fail->getMessage());
        $this->assertEquals('Error', $error->getMessage());

        $this->assertEquals($task, $success->getTask());
        $this->assertEquals($task, $fail->getTask());
        $this->assertEquals($task, $error->getTask());

        $this->assertEquals($json, $success->getJson());
        $this->assertEquals($json, $fail->getJson());
        $this->assertEquals($json, $error->getJson());

        $this->assertEquals('aaa', $success->getChecker());
        $this->assertEquals('aaa', $fail->getChecker());
        $this->assertEquals('aaa', $error->getChecker());

    }


}