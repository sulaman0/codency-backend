<?php

namespace App\Http\Resources\EcgCodes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class EcgCodesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    #[ArrayShape(['data' => "\Illuminate\Support\Collection", 'meta' => "array"])] public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total_records' => $this->total(),
                'current_records' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'next_page' => (string)$this->nextPageUrl(),
                'previous_page' => (string)$this->previousPageUrl(),
                'is_last_page' => (boolean)$this->lastPage() == $this->currentPage(),
                'query_strings' => (string)$request->getQueryString()
            ]
        ];
    }
}
