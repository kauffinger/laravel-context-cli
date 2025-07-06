<?php

namespace Kauffinger\Context;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Kauffinger\Context\Commands\ContextCommand;

class ContextServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-context-cli')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_context_cli_table')
            ->hasCommand(ContextCommand::class);
    }
}
