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
        dd($this);
        $ecgCode = $this->ecgCodes();
        return [
            'id' => (int)$ecgCode->id,
            'serial_no' => $this->collection->first()->getKey(),
//            'serial_no' => (int)$ecgCode->code(),
            'name' => (string)$this->name,
            'code' => $ecgCode->code(),
            'clr_code' => (string)$ecgCode->color_code,
        ];
    }
}
