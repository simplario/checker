<?php

namespace Simplario\Checker\Tests\Checker;

use Simplario\Checker\Checker\AbstractChecker;
use Simplario\Checker\Checker\Gateway;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;
use PHPUnit\Framework\TestCase;

class GatewayTest extends TestCase
{

    public function testInstance()
    {
        $checker = new Gateway();

        $this->assertInstanceOf(AbstractChecker::class, $checker);
    }

    public function testRunTestExists()
    {
        $this->expectException(SuccessException::class);

        $checker = new Gateway();
        $checker->check(['url' => 'http://google.com/', 'exists' => true]);
    }

    public function testRunTestExistsNot()
    {
        $this->expectException(FailException::class);

        $checker = new Gateway();
        $checker->check(['url' => 'http://google.com/', 'exists' => false]);
    }

}