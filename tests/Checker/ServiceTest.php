<?php

namespace Simplario\Checker\Tests\Checker;

use Simplario\Checker\Checker\AbstractChecker;
use Simplario\Checker\Checker\Service;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function testInstance()
    {
        $checker = new Service();

        $this->assertInstanceOf(AbstractChecker::class, $checker);

//        // OK
//        ['checker' => 'service', 'name' => 'htop', 'exists' => true, 'version' => '2.0.1', 'which' => '/usr/bin/htop'],
//        ['checker' => 'service', 'name' => 'php', 'exists' => true, 'version' => '7.0.8', 'which' => '/usr/bin/php'],
//        ['checker' => 'service', 'name' => 'rrrrrrrrrr', 'exists' => false],
//        // Errors
//        ['checker' => 'service', 'name' => 'htop', 'exists' => false],
//        ['checker' => 'service', 'name' => 'htop', 'version' => '9.9.9'],
//        ['checker' => 'service', 'name' => 'htop', 'which' => '/usr/bin/-UNDEFINED-'],


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