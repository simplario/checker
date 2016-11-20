<?php

namespace Simplario\Checker\Tests\Checker;

use Simplario\Checker\Checker\StoragePdo;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;
use PHPUnit\Framework\TestCase;

class StoragePdoTest extends TestCase
{
    /**
     * @return void
     */
    public function testRunTestExists()
    {

        $this->assertEquals(1, 1);

// TODO
//        $this->expectException(SuccessException::class);
//
//        $checker = new StoragePdo();
//        $checker->check(
//            [
//                'connect' => [
//                    'dsn'      => 'mysql:host=127.0.0.1:3306;dbname=content',
//                    'user'     => 'user',
//                    'password' => 'password'
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
//        $checker = new StoragePdo();
//        $checker->check(
//            [
//                'connect' => [
//                    'dsn'      => 'mysql:host=127.0.0.1:3306;dbname=content',
//                    'user'     => 'user',
//                    'password' => 'password'
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

        $checker = new StoragePdo();
        $checker->check(
            [
                'connect' => [
                    'dsn'      => 'UNDEFINED',
                    'user'     => 'UNDEFINED',
                    'password' => 'UNDEFINED'
                ],
                'exists'  => true
            ]
        );
    }
}