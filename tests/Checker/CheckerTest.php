<?php

namespace Simplario\Checker\Tests\Checker;

use Simplario\Checker\Checker\Filesystem;
use Simplario\Checker\ResultException\ErrorException;
use PHPUnit\Framework\TestCase;

/**
 * Class CheckerTest
 *
 * @package Simplario\Checker\Tests\Checker
 */
class CheckerTest extends TestCase
{

    /**
     * @return void
     */
    public function testRunTestExists()
    {
        $this->expectException(ErrorException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'undefinedTest' => 'undefinedParam']);
    }
}