<?php

namespace App\Models\Locations;

use App\AppHelper\AppHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LocationModel extends Model
{
    use HasFactory;

    protected $table = 'locations';
    protected $fillable = [
        'status'
    ];

    public function getAllLocations(): Collection
    {
        return LocationModel::where('status', 'active')->get();
    }

    public function getAllLocationsForFilters(): Collection
    {
        return LocationModel::all();
    }

    public function getAllLocationAdmin(Request $request)
    {
        $M = LocationModel::where('id', '<>', 0);
        if ($request->search) {
            $M = $M->where(function ($query) use ($request) {
                $query->orWhere('loc_nme', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('building_nme', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->status && $request->status <> 'all') {
            $M->where('status', $request->status);
        }

        return $M->orderBy('id', 'desc')->paginate(10);
    }

    function locationName(): string
    {
        return AppHelper::parseLocation($this);
    }

    function findById($id)
    {
        return LocationModel::find($id);
    }

    public function createOrUpdateLocation(mixed $loc_name, mixed $building_nme, $room, $floor, mixed $id): bool
    {
        $M = $this->findById($id);
        if (empty($M)) {
            $M = new LocationModel();
        }

        $M->loc_nme = $loc_name;
        $M->building_nme = $building_nme;
        $M->room = $room;
        $M->floor = $floor;
        $M->save();
        return true;
    }

    function saveBuildingNME($bNME)
    {
        $M = new LocationModel();
        $M->building_nme = $bNME;
        $M->save();
        return true;
    }

    function getAllBuildingsDropdown()
    {
        return LocationModel::orderBy('id', 'desc')->get();
    }

}
