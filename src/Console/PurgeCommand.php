<?php

namespace Ahmedwassef\LaravelEmailSentry\Console;

use Illuminate\Console\Command;

class PurgeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EmailSentry:purge {--days=24 : The number of days to retain Email Sentry data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune stale entries from the email sentry database table';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

    }
}