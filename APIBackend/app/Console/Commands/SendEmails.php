<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Mail\TestMail;
use App\Jobs\AutomatedEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // To call the queued job from the command, we can use the dispatch method.
        Log::channel('api_post_log')->error('Running Automated Email Job from command');
        // AutomatedEmail::dispatch();
        (new AutomatedEmail())->handle();
        $this->info('Automated Email Job dispatched successfully.');
    }
}
