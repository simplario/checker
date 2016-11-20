<?php

namespace Simplario\Checker\Tests\Checker;

use Simplario\Checker\Checker\AbstractChecker;
use Simplario\Checker\Checker\Filesystem;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;
use PHPUnit\Framework\TestCase;

class FileSystemTest extends TestCase
{

    public function testInstance()
    {
        $checker = new Filesystem();

        $this->assertInstanceOf(AbstractChecker::class, $checker);
    }

    public function testRunTestExists()
    {
        $this->expectException(SuccessException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'exists' => true]);
    }

    public function testRunTestExistsNot()
    {
        $this->expectException(FailException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'exists' => false]);
    }


    public function testRunTestFile()
    {
        $this->expectException(SuccessException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'file' => true]);
    }

    public function testRunTesttFileNot()
    {
        $this->expectException(FailException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'file' => false]);
    }


    public function testRunTestFolder()
    {
        $this->expectException(SuccessException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __DIR__, 'folder' => true]);
    }

    public function testRunTestFolderNot()
    {
        $this->expectException(FailException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __DIR__, 'folder' => false]);
    }


    public function testRunTestReadable()
    {
        $this->expectException(SuccessException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'readable' => true]);
    }

    public function testRunTestReadableNot()
    {
        $this->expectException(FailException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'readable' => false]);
    }


    public function testRunTestWritable()
    {
        $this->expectException(SuccessException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'writable' => true]);
    }

    public function testRunTestWritableNot()
    {
        $this->expectException(FailException::class);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'writable' => false]);
    }


    public function testRunTestChmod()
    {
        $this->expectException(SuccessException::class);
        $currentChmod = substr(sprintf('%o', fileperms(__FILE__)), -4);

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'chmod' => $currentChmod]);
    }

    public function testRunTestChmodNot()
    {
        $this->expectException(FailException::class);
        $currentChmod = '0987';

        $checker = new Filesystem();
        $checker->check(['path' => __FILE__, 'chmod' => $currentChmod]);
    }

}