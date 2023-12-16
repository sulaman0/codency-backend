<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationModel extends Model
{
    use HasFactory;

    protected $table = 'locations';

    public function getAllLocations(): Collection
    {
        return LocationModel::all();
    }

    function locationName(): string
    {
        return $this->loc_nme . ' - ' . $this->building_nme;
    }
}
