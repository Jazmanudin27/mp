<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendWaNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wa:send-notifications-legacy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Legacy command (Disabled). Use wa:generate-notifications and wa:process-outbox instead.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn('This command is legacy and disabled. Please use wa:generate-notifications or wa:process-outbox.');
        return 0;
    }
}
