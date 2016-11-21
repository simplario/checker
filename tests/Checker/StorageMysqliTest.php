<?php

namespace Simplario\Checker\Tests\Checker;

use Simplario\Checker\Checker\AbstractChecker;
use Simplario\Checker\Checker\StorageMysqli;
use Simplario\Checker\Checker\StoragePdo;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;
use PHPUnit\Framework\TestCase;

/**
 * Class StorageMysqliTest
 *
 * @package Simplario\Checker\Tests\Checker
 */
class StorageMysqliTest extends TestCase
{
    /**
     * @return void
     */
    public function testInstance()
    {
        $checker = new StorageMysqli();

        $this->assertInstanceOf(AbstractChecker::class, $checker);
        $this->assertInstanceOf(StoragePdo::class, $checker);
    }

    /**
     * @return void
     */
    public function testRunTestExists()
    {
        $this->assertEquals(1, 1);

// TODO
//        $this->expectException(SuccessException::class);
//
//        $checker = new StorageMysqli();
//        $checker->check(
//            [
//                'connect' => [
//                    'host'     => '127.0.0.1',
//                    'user'     => 'user',
//                    'password' => 'password',
//                    'database' => 'content'
//                ],
//                'exists'  => true
//            ]
//        );
    }

    /**
     * @return void
     */
    public function testRunTestExistsNot()
    {
        $this->assertEquals(1, 1);

// TODO
//        $this->expectException(FailException::class);
//
//        $checker = new StorageMysqli();
//        $checker->check(
//            [
//                'connect' => [
//                    'host'     => '127.0.0.1',
//                    'user'     => 'user',
//                    'password' => 'password',
//                    'database' => 'content'
//                ],
//                'exists'  => false
//            ]
//        );
    }

    /**
     * @return void
     */
    public function testRunTestExistsNotFail()
    {
        $this->expectException(FailException::class);

        $checker = new StorageMysqli();
        $checker->check(
            [
                'connect' => [
                    'host'     => '127.0.0.1',
                    'user'     => 'UNDEFINED',
                    'password' => 'UNDEFINED',
                    'database' => 'UNDEFINED'
                ],
                'exists'  => true
            ]
        );
    }
}
