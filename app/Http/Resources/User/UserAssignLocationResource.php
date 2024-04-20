<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Locations\RoomLocationCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAssignLocationResource extends JsonResource
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
            'building' => $this->buildingName(),
            'rooms' => new RoomLocationCollection(User::rooms($this->user_id, $this->building_id))
        ];
    }
}
