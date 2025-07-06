<?php

namespace Kauffinger\Context\Commands;

use Illuminate\Console\Command;

class GetLatestLaravelLogEntryCommand extends Command
{
    public $signature = 'context:get:log
                        {--lines=1 : Number of log lines to display}';

    public $description = 'Get the latest Laravel log entries';

    public function handle(): int
    {
        $lines = (int) $this->option('lines');
        $logPath = storage_path('logs/laravel.log');

        if (! file_exists($logPath)) {
            $this->error('Laravel log file not found at: '.$logPath);

            return self::FAILURE;
        }

        $logContent = $this->getLastLines($logPath, $lines);

        if (empty($logContent)) {
            $this->info('No log entries found.');

            return self::SUCCESS;
        }

        $this->info('Latest log entries:');
        $this->line('');
        $this->line($logContent);

        return self::SUCCESS;
    }

    private function getLastLines(string $filePath, int $lines): string
    {
        $fileLines = file($filePath, FILE_IGNORE_NEW_LINES);

        if (! $fileLines) {
            return '';
        }

        $lastLines = array_slice($fileLines, -$lines);

        return implode("\n", $lastLines);
    }
}
