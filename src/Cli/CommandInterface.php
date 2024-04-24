<?php

declare(strict_types=1);

namespace Feed2Email\Cli;

interface CommandInterface
{
    public function execute(array $argv): int;
}
