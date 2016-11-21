<?php

namespace Simplario\Checker\Tests\Checker;

use Simplario\Checker\Checker\AbstractChecker;
use Simplario\Checker\Checker\Service;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;
use PHPUnit\Framework\TestCase;

/**
 * Class ServiceTest
 *
 * @package Simplario\Checker\Tests\Checker
 */
class ServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function testInstance()
    {
        $checker = new Service();

        $this->assertInstanceOf(AbstractChecker::class, $checker);
    }

    /**
     * @return void
     */
    public function testRunTestExists()
    {
        $this->expectException(SuccessException::class);

        $checker = new Service();
        $checker->check(['name' => 'php', 'exists' => true]);
    }

    /**
     * @return void
     */
    public function testRunTestExistsNot()
    {
        $this->expectException(FailException::class);

        $checker = new Service();
        $checker->check(['name' => 'php', 'exists' => false]);
    }

    /**
     * @return void
     */
    public function testRunTestWhich()
    {
        $this->assertEquals(1, 1);

// TODO
//        $this->expectException(SuccessException::class);
//
//        $checker = new Service();
//        $checker->check(['name' => 'php', 'which' => '/usr/bin/php']);
    }

    public function testRunTestWhichNot()
    {
        $this->expectException(FailException::class);

        $checker = new Service();
        $checker->check(['name' => 'php', 'which' => '/UNDEFINED/UNDEFINED']);
    }
}
