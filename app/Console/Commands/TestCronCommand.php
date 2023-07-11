<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCronCommand extends Command
{
    protected $signature = 'test:cron';

    protected $description = 'Command description';

    public function handle(): void
    {
        $this->line('v2 test cron job, now at ' . now()->toDateTimeString());
    }
}
