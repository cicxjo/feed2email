<?php

declare(strict_types=1);

namespace Test\Autoloader;

use Feed2Email\Autoload;
use PHPUnit\Framework\TestCase;

class AutoloaderTest extends TestCase
{
    private Autoload $autoloader;

    protected function setUp(): void
    {
        $this->autoloader = new Autoload();
        $this->autoloader->addNamespace('Test', 'test');
    }

    public function testFindFiles(): void
    {
        $actual = $this->autoloader->loadClass('Test\Autoloader\_Files\A');
        $expected = 'test/Autoloader/_Files/A.php';
        $this->assertSame($expected, $actual);

        $actual = $this->autoloader->loadClass('Test\Autoloader\_Files\B');
        $expected = 'test/Autoloader/_Files/B.php';
        $this->assertSame($expected, $actual);
    }

    public function testFindNestedFiles(): void
    {
        $actual = $this->autoloader->loadClass('Test\Autoloader\_Files\Nested\A');
        $expected = 'test/Autoloader/_Files/Nested/A.php';
        $this->assertSame($expected, $actual);

        $actual = $this->autoloader->loadClass('Test\Autoloader\_Files\Nested\B');
        $expected = 'test/Autoloader/_Files/Nested/B.php';
        $this->assertSame($expected, $actual);
    }

    public function testMissingFile(): void
    {
        $actual = $this->autoloader->loadClass('This\Class\Does\Not\Exists');
        $this->assertFalse($actual);
    }
}
