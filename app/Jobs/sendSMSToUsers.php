<?php

namespace App\Jobs;

use App\Models\Notify\SMS;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Melipayamak\MelipayamakApi;

class sendSMSToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $sms;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SMS $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::whereNotNull('mobile')->get();
        foreach ($users as $user) {
            try {
                $username = Config::get('sms.username');
                $password = Config::get('sms.password');
                $api = new MelipayamakApi($username, $password);
                $sms = $api->sms();
                $to = '0' . $user->mobile;
                $from = Config::get('sms.otp_from');
                $text = $this->sms->body;
                $response = $sms->send($to, $from, $text);
                $json = json_decode($response);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
