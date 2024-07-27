<?php

namespace App\Console\Commands;

use App\AppHelper\AppHelper;
use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\Locations\RoomModel;
use App\Models\RoomAndAlert\RoomAlertModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ConvertTextToSoundCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-text-to-sound';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert text to sound';


    function logInfo($message)
    {
        $this->info($message);
        Log::info($message);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        DB::transaction(function () {
            RoomModel
                ::where('status', 'active')
                ->where('audio_status', 'pending')->chunk(100, function ($rooms) {
                    foreach ($rooms as $room) {
                        $this->logInfo("room " . $room->id . '  name ' . $room->room_nme);
                        // set the status location is now in audio process.
                        $room->setAudioCompilingStatus('processing');

                        $this->logInfo("update status of room " . $room->id . '  name ' . $room->room_nme);

                        // location string.
                        $audio = $room->locationName();

                        $this->logInfo("complete audio of room " . $room->id . '  name ' . $room->room_nme . ' loc nmae ' . $audio);

                        $ecgCodes = EcgCodesModel::where('status', 'active')->get();
                        foreach ($ecgCodes as $ecgCode) {

                            $this->logInfo("ECG Code" . $ecgCode->id . '  name ' . $ecgCode->name);

                            // set the status for alert code.
                            $ecgCode->setAudioCompilingStatus('processing');

                            $this->logInfo("ECG Code status updated" . $ecgCode->id . '  name ' . $ecgCode->name);


                            // make an audio file
                            $audio = sprintf("%s %s", $ecgCode->name, $audio);

                            $this->logInfo("complete audio " . $ecgCode->id . '  name ' . $ecgCode->name . ' ' . $audio);

                            $audioFileName = $room->id . '_' . $ecgCode->id;
                            $audioParse = $this->convertTextToSound($audio, $audioFileName);
                            $fileName = sprintf("%s_%s.mp3", $room->id, $ecgCode->id);


                            $this->logInfo("File converted to sound, " . $audio);

                            if ($audioParse || Storage::disk('audio')->exists($fileName)) {
                                RoomAlertModel::saveAudio(
                                    $room->id,
                                    $ecgCode->id,
                                    Storage::disk('audio')->url($audioFileName . '.mp3'),
                                    $audio,
                                    $audioParse
                                );
                                $room->setAudioCompilingStatus('synced');
                                $ecgCode->setAudioCompilingStatus('synced');


                                $this->logInfo("record saved and status set to synced" . $ecgCode->id . '  name ' . $ecgCode->name . ' ' . $audio);
                            }
                        }
                    }
                });
        });


        DB::transaction(function () {
            EcgCodesModel
                ::where('status', 'active')
                ->where('audio_status', 'pending')->chunk(100, function ($ecgCodes) {
                    foreach ($ecgCodes as $code) {
                        $code->setAudioCompilingStatus('processing');
                        $audio = $code->ecg_code_nme;
                        $rooms = RoomModel::all();
                        foreach ($rooms as $room) {
                            $room->setAudioCompilingStatus('processing');
                            $audio = sprintf("%s %s", $audio, $room->locationName());

                            $audioFileName = $room->id . '_' . $code->id;
                            $audioParse = $this->convertTextToSound($audio, $audioFileName);

                            $fileName = sprintf("%s_%s.mp3", $room->id, $code->id);
                            if ($audioParse && Storage::disk('audio')->exists($fileName)) {
                                RoomAlertModel::saveAudio(
                                    $room->id,
                                    $code->id,
                                    Storage::disk('audio')->path('/') . $audioFileName . '.mp3',
                                    $audio,
                                    $audioParse
                                );
                                $room->setAudioCompilingStatus('synced');
                                $code->setAudioCompilingStatus('synced');
                            }
                        }
                    }
                });
        });
    }


    function convertTextToSound($text, $fileName)
    {

        // Mock Response.
        return json_encode([]);

        if (Storage::disk('audio')->exists($fileName . '.mp3')) {
            Storage::disk('audio')->delete($fileName . '.mp3'); // delete the audio file if exits.
        }

        // Create file path
        $path = Storage::disk('audio')->path('/');


        $apiResponse = Http::post("https://speechgen.io/index.php?r=api/text", [
            'token' => 'ec2e672c45df5ba3a694af6886fd5a25',
            'email' => 'qkhan.it@gmail.com',
            'voice' => 'christopher',
            'text' => $text,
            'format' => 'mp3',
            'speed' => 1,
            'pitch' => 0.9,
            'emotion' => 'good',
        ]);

        if ($apiResponse->successful()) {
            $response = $apiResponse->json();
            if ($response['status'] == 1) {
                copy($response["file"], $path . $fileName . '.' . $response["format"]); // copy the file.
                if ($response['balans'] < 2000) {
                    AppHelper::sendHighEmergencyAlert('Text to Sound API Balance is too low');
                }

            } else {
                AppHelper::sendHighEmergencyAlert('Error: on Text to Sound conversation');
            }

            return json_encode($response);
        } else {
            AppHelper::sendHighEmergencyAlert("Error when converting text to sound call.");
            Log::error("Error when converting text to sound call.", [
                'response' => json_encode($apiResponse)
            ]);
        }
    }

}
