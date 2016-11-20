<?php

namespace Simplario\Checker\Tests\Checker;

use Simplario\Checker\Checker\AbstractChecker;
use Simplario\Checker\Checker\Filesystem;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;
use PHPUnit\Framework\TestCase;

/**
 * Class FileSystemTest
 *
 * @package Simplario\Checker\Tests\Checker
 */
class FileSystemTest extends TestCase
{
    /**
     * @return void
     */
    public function testInstance()
    {
        $checker = new Filesystem();

        $this->assertInstanceOf(AbstractChecker::class, $checker);
    }

    /**
     * @return void
     */
    public function testRunTestExists()
    {
        $this->expectException(SuccessException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'exists' => true]);
    }

    /**
     * @return void
     */
    public function testRunTestExistsNot()
    {
        $this->expectException(FailException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'exists' => false]);
    }

    /**
     * @return void
     */
    public function testRunTestFile()
    {
        $this->expectException(SuccessException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'file' => true]);
    }

    /**
     * @return void
     */
    public function testRunTesttFileNot()
    {
        $this->expectException(FailException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'file' => false]);
    }

    /**
     * @return void
     */
    public function testRunTestFolder()
    {
        $this->expectException(SuccessException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __DIR__, 'folder' => true]);
    }

    /**
     * @return void
     */
    public function testRunTestFolderNot()
    {
        $this->expectException(FailException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __DIR__, 'folder' => false]);
    }

    /**
     * @return void
     */
    public function testRunTestReadable()
    {
        $this->expectException(SuccessException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'readable' => true]);
    }

    /**
     * @return void
     */
    public function testRunTestReadableNot()
    {
        $this->expectException(FailException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'readable' => false]);
    }

    /**
     * @return void
     */
    public function testRunTestWritable()
    {
        $this->expectException(SuccessException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'writable' => true]);
    }

    /**
     * @return void
     */
    public function testRunTestWritableNot()
    {
        $this->expectException(FailException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'writable' => false]);
    }

    /**
     * @return void
     */
    public function testRunTestChmod()
    {
        $this->expectException(SuccessException::class);
        $currentChmod = substr(sprintf('%o', fileperms(__FILE__)), -4);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'chmod' => $currentChmod]);
    }

    /**
     * @return void
     */
    public function testRunTestChmodNot()
    {
        $this->expectException(FailException::class);
        $currentChmod = '0987';

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'chmod' => $currentChmod]);
    }
}