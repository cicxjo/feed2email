<?php

declare(strict_types=1);

namespace Test\CommandRegistry;

use Feed2Email\Cli\CommandRegistry;
use PHPUnit\Framework\TestCase;
use Test\CommandRegistry\_Files\BarCommand;
use Test\CommandRegistry\_Files\FooCommand;

class CommandRegistryTest extends TestCase
{
    private CommandRegistry $commandRegistry;

    protected function setUp(): void
    {
        (new \Feed2Email\Autoload())->addNamespace('Feed2Email', 'src')
                                    ->addNamespace('Test', 'test')
                                    ->register();

        $this->commandRegistry = new CommandRegistry();
    }

    public function testRegisterCommandFooFromCommandRegistry(): void
    {
        $commandName = 'foo';
        $command = new FooCommand();
        $this->commandRegistry->registerCommand($commandName, $command);

        $actual = $this->commandRegistry->getCommand($commandName);
        $expected = $command;

        $this->assertSame($actual, $expected);
    }

    public function testRegisterCommandBarFromCommandRegistry(): void
    {
        $commandName = 'bar';
        $command = new BarCommand();
        $this->commandRegistry->registerCommand($commandName, $command);

        $actual = $this->commandRegistry->getCommand($commandName);
        $expected = $command;

        $this->assertSame($actual, $expected);
    }
}
