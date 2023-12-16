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
            'id' => (int)$this->id,
            'serial_no' => $this->serialNo(),
            'name' => (string)$this->name,
            'code' => $this->code(),
            'clr_code' => (string)$this->color_code,
        ];
    }
}
