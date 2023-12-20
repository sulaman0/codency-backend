<?php

namespace App\Http\Resources\EcgAlerts;

use App\AppHelper\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EcgAlertsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $ecgCode = $this->ecgCode();
        $detailsAr = [
            'code' => [
                'name' => 'Code',
                'value' => (string)$ecgCode->code
            ],
            'location' => [
                'name' => 'Location',
                'value' => (string)$this->locationNME()
            ],
            'alarm_by' => [
                'name' => 'Alarm By',
                'value' => (string)$this->alarmByNME()
            ],
            'details' => [
                'name' => 'Details',
                'value' => (string)$ecgCode->details
            ],
            'alarm_triggered_at' => [
                'name' => 'Alarm At',
                'value' => AppHelper::getAppDateAndTime(
                    $this->alarm_triggered_at
                )
            ],
            'responded_by' => [
                'name' => 'Responded By',
                'value' => (string)$this->respondedByNME()
            ],
            'responded_at' => [
                'name' => 'Responded At',
                'value' => $this->respond_at ? AppHelper::getAppDateAndTime(
                    $this->respond_at
                ) : ''
            ],
            'played_at_amplifier' => [
                'name' => 'Played At Amplifier',
                'value' => $this->played_at_amplifier ? AppHelper::getAppDateAndTime(
                    $this->played_at_amplifier
                ) : ''
            ],
        ];

        foreach ($detailsAr as $key => $ar) {
            if (empty($ar['value'])) {
                unset($detailsAr[$key]);
            }
        }


        return [
            'id' => (int)$this->id,
            'name' => (string)$this->ecg_code_nme,
            'ecg_code' => (string)$ecgCode->code,
            'ecg_color_code' => (string)$ecgCode->color_code,
            'details' => $detailsAr,
            'responded_action' => (string)$this->respond_action,
            'should_show_action_btn' => (boolean)$this->shouldShowActionBtn($ecgCode->action),
        ];
    }
}
