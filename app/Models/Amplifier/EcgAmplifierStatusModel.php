<?php

namespace App\Models\Amplifier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EcgAmplifierStatusModel extends Model
{
    use HasFactory;

    protected $table = 'amplifier_status';

    function saveAmplifierStatus($deviceId, $health)
    {
        $M = new EcgAmplifierStatusModel();
        $M->device_id = $deviceId;
        $M->battery_health = $health;
        $M->save();
    }

    public function getAllUpdates(Request $request)
    {
        return EcgAmplifierStatusModel::orderBy('id', 'desc')->limit(10)->get();
    }
}
