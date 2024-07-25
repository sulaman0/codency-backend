<?php

namespace App\Models\RoomAndAlert;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomAlertModel extends Model
{
    use HasFactory;
    protected $table = 'loc_room_ecg_alerts';

    static function saveAudio($roomId, $ecgAlertId, $audioFilePath, $audioText, $apiResponse)
    {
        $Model = new RoomAlertModel();
        $Model->room_id = $roomId;
        $Model->ecg_alerts_id = $ecgAlertId;
        $Model->audio_url = $audioFilePath;
        $Model->audio_text = $audioText;
        $Model->api_response = $apiResponse;
        $Model->save();
    }

    public static function deleteByRoomId($roomId)
    {
        RoomAlertModel::where('room_id', $roomId)->delete();
    }

    public static function deleteByAlertId($roomId)
    {
        RoomAlertModel::where('ecg_alerts_id', $roomId)->delete();
    }
}
