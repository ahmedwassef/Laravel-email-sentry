<?php

namespace Ahmedwassef\LaravelEmailSentry\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EmailSentry:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the EmailSentry resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'email-sentry-config',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'email-sentry-migrations',
            '--force' => true,
        ]);
    }

}