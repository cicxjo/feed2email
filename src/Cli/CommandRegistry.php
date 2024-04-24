<?php

declare(strict_types=1);

namespace Feed2Email\Cli;

class CommandRegistry
{
    private array $commands = [];

    public function registerCommand(string $commandName, CommandInterface $command): void
    {
        $this->commands[$commandName] = $command;
    }

    public function getCommand(string $commandName): ?CommandInterface
    {
        return $this->commands[$commandName] ?? null;
    }
}
