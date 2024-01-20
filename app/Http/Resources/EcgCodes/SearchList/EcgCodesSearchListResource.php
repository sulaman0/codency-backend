<?php

namespace App\Http\Resources\EcgCodes\SearchList;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class EcgCodesSearchListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "mixed", 'id' => "mixed"])] public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
            'code' => $this->code,
            'occurrence' => '',
        ];
    }
}
