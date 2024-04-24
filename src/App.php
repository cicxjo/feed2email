<?php

declare(strict_types=1);

namespace Feed2Email;

use Feed2Email\Cli\CommandInterface;
use Feed2Email\Cli\CommandRegistry;

class App
{
    private string $defaultCommand = '';
    private CommandRegistry $commandRegistry;

    public function __construct()
    {
        $this->commandRegistry = new CommandRegistry();
    }

    public function setDefaultCommand(string $commandName): self
    {
        $this->defaultCommand = $commandName;

        return $this;
    }

    public function registerCommand(string $commandName, CommandInterface $command): self
    {
        $this->commandRegistry->registerCommand($commandName, $command);

        return $this;
    }

    public function getCommand(string $commandName): CommandInterface
    {
        return $this->commandRegistry->getCommand($commandName)
            ?? $this->commandRegistry->getCommand($this->defaultCommand);
    }

    public function runCommand(array $argv): int
    {
        $commandName = $this->defaultCommand;

        if (isset($argv[1])) {
            $commandName = $argv[1];
        }

        $command = $this->getCommand($commandName);
        $command = new $command();

        return $command->execute($argv);
    }
}
