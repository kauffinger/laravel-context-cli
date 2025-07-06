<?php

namespace Kauffinger\Context\Commands;

use Illuminate\Console\Command;

class ContextCommand extends Command
{
    public $signature = 'laravel-context-cli';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
