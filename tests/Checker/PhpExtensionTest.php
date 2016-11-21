<?php

namespace Simplario\Checker\Tests\Checker;

use Simplario\Checker\Checker\AbstractChecker;
use Simplario\Checker\Checker\PhpExtension;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;
use PHPUnit\Framework\TestCase;

/**
 * Class PhpExtensionTest
 *
 * @package Simplario\Checker\Tests\Checker
 */
class PhpExtensionTest extends TestCase
{
    /**
     * @return void
     */
    public function testInstance()
    {
        $checker = new PhpExtension();

        $this->assertInstanceOf(AbstractChecker::class, $checker);
    }

    /**
     * @return void
     */
    public function testRunTestExists()
    {
        $this->expectException(SuccessException::class);

        $checker = new PhpExtension();
        $checker->check(['extension' => 'json', 'exists' => true]);
    }

    /**
     * @return void
     */
    public function testRunTestExistsNot()
    {
        $this->expectException(FailException::class);

        $checker = new PhpExtension();
        $checker->check(['extension' => '-UNDEFINED-', 'exists' => true]);
    }
}
