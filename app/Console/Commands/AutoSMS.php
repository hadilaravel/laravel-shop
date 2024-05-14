<?php

namespace App\Console\Commands;

use App\Jobs\sendSMSToUsers;
use App\Models\Notify\SMS;
use Illuminate\Console\Command;

class AutoSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sendSMS';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $SMSTOSends = SMS::where('published_at' , '=' , now())->where('status' , 1)->get();
        foreach ($SMSTOSends as $SMSTOSend){
            sendSMSToUsers::dispatch($SMSTOSend);
        }
    }
}
