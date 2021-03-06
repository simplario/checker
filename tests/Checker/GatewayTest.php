<?php

namespace Simplario\Checker\Tests\Checker;

use Simplario\Checker\Checker\AbstractChecker;
use Simplario\Checker\Checker\Gateway;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;
use PHPUnit\Framework\TestCase;

/**
 * Class GatewayTest
 *
 * @package Simplario\Checker\Tests\Checker
 */
class GatewayTest extends TestCase
{
    /**
     * @return void
     */
    public function testInstance()
    {
        $checker = new Gateway();

        $this->assertInstanceOf(AbstractChecker::class, $checker);
    }

    /**
     * @return void
     */
    public function testRunTestExists()
    {
        $this->expectException(SuccessException::class);

        $checker = new Gateway();
        $checker->check(['url' => 'http://google.com/', 'exists' => true]);
    }

    /**
     * @return void
     */
    public function testRunTestExistsNot()
    {
        $this->expectException(FailException::class);

        $checker = new Gateway();
        $checker->check(['url' => 'http://google.com/', 'exists' => false]);
    }
}
