<?php

namespace App\Http\Resources\EcgAlerts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnPlayedAlarmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tune' => $this->preferred_lang == 'ar' ? $this->tune_ar : $this->tune_en,
            'played_at' => $this->played_at_amplifier,
            'name' => $this->ecg_code_nme,
            'times' => $this->no_of_times_play,
        ];
    }
}
