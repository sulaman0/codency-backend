<?php

namespace App\Http\Resources\EcgCodes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EcgCodesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'serial_no' => (int)$this->id,
            'name' => (string)$this->name,
            'code' => (string)$this->code,
            'clr_code' => (string)$this->color_code,
        ];
    }
}
