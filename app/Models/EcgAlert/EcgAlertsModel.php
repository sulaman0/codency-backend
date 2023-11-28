<?php

namespace App\Models\EcgAlert;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcgAlertsModel extends Model
{
    use HasFactory;

    protected $table = 'ecg_alerts';

    function saveAlert($ecgCodeId, $ecgCodeNme, $locationId, $locationNme, $triggeredById, $triggeredAt)
    {
        $M = new EcgAlertsModel();
        $M->ecg_code_id = $ecgCodeId;
        $M->ecg_code_nme = $ecgCodeNme;
        $M->location_id = $locationId;
        $M->location_nme = $locationNme;
        $M->alarm_triggered_by_id = $triggeredById;
        $M->alarm_triggered_at = $triggeredAt;
        return $M->save();
    }

    function updateAlertResponded(EcgAlertsModel $ecgAlertsModel, $respondedById, $respondedByAt, $action)
    {
        $ecgAlertsModel->respond_by_id = $respondedById;
        $ecgAlertsModel->respond_at = $respondedByAt;
        $ecgAlertsModel->action = $action;
        $ecgAlertsModel->save();
    }
}
