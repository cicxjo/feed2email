<?php

declare(strict_types=1);

namespace Test\CommandRegistry\_Files;

use Feed2Email\Cli\CommandInterface;

class FooCommand implements CommandInterface
{
    public function execute(array $argv): int
    {
        return 0;
    }
}
