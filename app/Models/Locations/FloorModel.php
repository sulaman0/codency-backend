<?php

namespace App\Models\Locations;

use App\AppHelper\AppHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FloorModel extends Model
{
    use HasFactory;

    protected $table = 'loc_floor';
    protected $fillable = [
        'status'
    ];

    public function saveFloor(mixed $building, mixed $floor_name)
    {
        $M = new FloorModel();
        $M->building_id = $building;
        $M->floor_nme = $floor_name;
        $M->status = 'active';
        $M->save();
    }

    function getAllFloorDropdown()
    {
        return FloorModel::orderBy('id', 'desc')->get();
    }
}
