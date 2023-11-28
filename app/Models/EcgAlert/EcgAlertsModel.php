<?php

namespace App\Models\EcgAlert;

use App\Models\EcgCodes\EcgCodesAlertsAssignedToUsersModel;
use App\Models\EcgCodes\EcgCodesAssignedToUsersModel;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\User;
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
        $M->save();
        return $M;
    }

    function updateAlertResponded(EcgAlertsModel $ecgAlertsModel, $respondedById, $respondedByAt, $action)
    {
        $ecgAlertsModel->respond_by_id = $respondedById;
        $ecgAlertsModel->respond_at = $respondedByAt;
        $ecgAlertsModel->action = $action;
        $ecgAlertsModel->save();
    }

    function updateAlertAmplifiedStatus(EcgAlertsModel $ecgAlertsModel, $playedAtAmplified)
    {
        $ecgAlertsModel->played_at_amplifier = $playedAtAmplified;
        $ecgAlertsModel->save();
    }

    public function getAllAlerts(mixed $loggedInUserId)
    {
        return EcgAlertsModel::leftJoin('ecg_codes_alert_assigned_users', 'ecg_alerts.ecg_code_id', '=', 'ecg_codes_alert_assigned_users.ecg_code_id')
            ->where('ecg_codes_alert_assigned_users.user_id', $loggedInUserId)->paginate();
    }

    function alarmBy()
    {
        return $this->hasOne(User::class, 'id', 'alarm_triggered_by_id')->first();
    }

    function alarmByNME()
    {
        $alarmBy = $this->alarmBy();
        return $alarmBy instanceof User ? $alarmBy->name : '';
    }

    function respondedBy()
    {
        return $this->hasOne(User::class, 'id', 'respond_by_id')->first();
    }

    function respondedByNME()
    {
        $alarmBy = $this->respondedBy();
        return $alarmBy instanceof User ? $alarmBy->name : '';
    }

    function ecgCode()
    {
        return $this->hasOne(EcgCodesModel::class, 'id', 'ecg_code_id')->first();
    }

    static function getByIdFindFail($id)
    {
        return EcgAlertsModel::findOrFail($id);
    }

    function shouldShowActionBtn($action)
    {
        if ($action == "sent_to_amplifier_directly") {
            return false;
        } else if ($action == "sent_to_manager" && empty($this->respond_by_id)) {
            return true;
        }
    }
}
