<?php

namespace Simplario\Checker\Tests\Output;

use Simplario\Checker\Output\AbstractOutput;
use Simplario\Checker\Output\Console;
use PHPUnit\Framework\TestCase;

class ConsoleTest extends TestCase
{
    public function testInstance()
    {
        $output = new Console();
        $this->assertInstanceOf(AbstractOutput::class, $output);
    }

    public function testWrite()
    {
        $output = new Console();
        ob_start();
        $output->write('msg123', Console::TYPE_SUCCESS);
        $string = ob_get_contents();
        ob_end_clean();

        $this->assertContains('msg123', $string);
    }

}