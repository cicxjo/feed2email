<?php

declare(strict_types=1);

namespace Test\App;

use Feed2Email\App;
use Feed2Email\Cli\CommandInterface;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    private App $app;

    protected function setUp(): void
    {
        (new \Feed2Email\Autoload())->addNamespace('Feed2Email', 'src')
                                    ->addNamespace('Test', 'test')
                                    ->register();


        $this->app = new App();
    }

    public function testRegisterCommands(): void
    {
        $commandName = 'foo';
        $command = new class implements CommandInterface {
            public function execute(array $argv): int
            {
                return 0;
            }
        };
        $argv = ['scriptName', $commandName];
        $this->app->registerCommand($commandName, $command);
        $actual = $this->app->runCommand($argv);
        $expected = 0;
        $this->assertEquals($actual, $expected);

        $commandName = 'bar';
        $command = new class implements CommandInterface {
            public function execute(array $argv): int
            {
                return 1;
            }
        };
        $argv = ['scriptName', $commandName];
        $this->app->registerCommand($commandName, $command);
        $actual = $this->app->runCommand($argv);
        $expected = 1;
        $this->assertEquals($actual, $expected);
    }

    public function testRegisterDefaultCommand(): void
    {
        $commandName = 'hello';
        $defaultCommandName = $commandName;
        $command = new class implements CommandInterface {
            public function execute(array $argv): int
            {
                return 2;
            }
        };
        $this->app->registerCommand($commandName, $command)
                  ->setDefaultCommand($defaultCommandName);
        $expected = 2;

        $argv = [];
        $actual = $this->app->runCommand($argv);
        $this->assertEquals($actual, $expected);

        $argv = ['scriptName'];
        $actual = $this->app->runCommand($argv);
        $this->assertEquals($actual, $expected);

        $argv = ['scriptName', 'azerty'];
        $actual = $this->app->runCommand($argv);
        $this->assertEquals($actual, $expected);
    }
}
