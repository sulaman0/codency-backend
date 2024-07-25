<?php

namespace App\Console\Commands;

use App\Mail\AmplifierOfflineMail;
use App\Models\Amplifier\EcgAmplifierStatusModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAlertToAdminIfAmplifierOfflineCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-alert-to-admin-if-amplifier-offline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to users when amplifier get offline!';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lastAmplifierStatus = EcgAmplifierStatusModel::orderBy('id', 'desc')->first();
        $currentTime = Carbon::now();
        $differenceInSeconds = $currentTime->diffInSeconds($lastAmplifierStatus->created_at);
        if ($differenceInSeconds > 30) {
            Mail::to([
                "symikhan70@gmail.com",
                "qkhan.it@gmail.com",
            ])->send(new AmplifierOfflineMail());
        }
    }
}
