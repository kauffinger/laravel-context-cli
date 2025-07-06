<?php

use Kauffinger\Context\Commands\GetLatestLaravelLogEntryCommand;

it('can get latest log entry when file exists', function () {
    $logPath = storage_path('logs/laravel.log');

    if (! is_dir(dirname($logPath))) {
        mkdir(dirname($logPath), 0755, true);
    }

    file_put_contents($logPath, "[2024-01-01 10:00:00] local.INFO: First log entry\n");
    file_put_contents($logPath, "[2024-01-01 10:01:00] local.ERROR: Second log entry\n", FILE_APPEND);
    file_put_contents($logPath, "[2024-01-01 10:02:00] local.DEBUG: Latest log entry\n", FILE_APPEND);

    $this->artisan(GetLatestLaravelLogEntryCommand::class)
        ->expectsOutput('Latest log entries:')
        ->expectsOutputToContain('[2024-01-01 10:02:00] local.DEBUG: Latest log entry')
        ->assertExitCode(0);

    unlink($logPath);
});

it('can get multiple log entries with lines option', function () {
    $logPath = storage_path('logs/laravel.log');

    if (! is_dir(dirname($logPath))) {
        mkdir(dirname($logPath), 0755, true);
    }

    file_put_contents($logPath, "[2024-01-01 10:00:00] local.INFO: First log entry\n");
    file_put_contents($logPath, "[2024-01-01 10:01:00] local.ERROR: Second log entry\n", FILE_APPEND);
    file_put_contents($logPath, "[2024-01-01 10:02:00] local.DEBUG: Third log entry\n", FILE_APPEND);

    $this->artisan(GetLatestLaravelLogEntryCommand::class, ['--lines' => 3])
        ->expectsOutput('Latest log entries:')
        ->expectsOutputToContain('log entry')
        ->assertExitCode(0);

    unlink($logPath);
});

it('handles missing log file gracefully', function () {
    $logPath = storage_path('logs/laravel.log');

    if (file_exists($logPath)) {
        unlink($logPath);
    }

    $this->artisan(GetLatestLaravelLogEntryCommand::class)
        ->expectsOutput('Laravel log file not found at: '.$logPath)
        ->assertExitCode(1);
});

it('handles empty log file', function () {
    $logPath = storage_path('logs/laravel.log');

    if (! is_dir(dirname($logPath))) {
        mkdir(dirname($logPath), 0755, true);
    }

    file_put_contents($logPath, '');

    $this->artisan(GetLatestLaravelLogEntryCommand::class)
        ->expectsOutput('No log entries found.')
        ->assertExitCode(0);

    unlink($logPath);
});
