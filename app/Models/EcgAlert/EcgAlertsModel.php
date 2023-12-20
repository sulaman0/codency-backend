<?php

namespace App\Models\EcgAlert;

use App\AppHelper\AppHelper;
use App\Models\EcgCodes\EcgCodesAlertsAssignedToUsersModel;
use App\Models\EcgCodes\EcgCodesAssignedToUsersModel;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\Locations\LocationModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        $ecgAlertsModel->responded_action = $action;
        $ecgAlertsModel->save();
    }

    public function getAllAlerts(mixed $loggedInUserId, $request)
    {
        $M = EcgAlertsModel::leftJoin('ecg_codes_alert_assigned_users', 'ecg_alerts.ecg_code_id', '=', 'ecg_codes_alert_assigned_users.ecg_code_id')
            ->select('*')->addSelect('ecg_alerts.id as id')
            ->where('ecg_codes_alert_assigned_users.user_id', $loggedInUserId);

        if ($request->user_id) {
            $M->where('ecg_alerts.alarm_triggered_by_id', $request->user_id);
        }

        if ($request->code_id) {
            $M->where('ecg_alerts.ecg_code_id', $request->code_id);
        }

        return $M->orderBy('ecg_alerts.id', 'desc')->paginate();
    }

    public function getAllAlertAdmin($request, $limit = false)
    {
        $query = DB::table('ecg_alerts')
            ->select(
                'ecg_alerts.id as id',
                'ecg_codes.name as ecg_code_nme',
                'ecg_code_id',
                DB::raw('CONCAT_WS(" ", locations.loc_nme, locations.building_nme) as location_nme'),
                'alarm_triggered_by_id',
                'alarm_triggered_at',
                'respond_by_id',
                'respond_at',
                'played_at_amplifier',
                'responder.name as responder_name',
                'sender.name as sender_name',
                'ecg_codes.code',
                'ecg_codes.color_code',
            )
            ->leftJoin('users as responder', 'ecg_alerts.respond_by_id', '=', 'responder.id')
            ->leftJoin('ecg_codes', 'ecg_alerts.ecg_code_id', '=', 'ecg_codes.id')
            ->leftJoin('locations', 'ecg_alerts.location_id', '=', 'locations.id')
            ->leftJoin('users as sender', 'ecg_alerts.alarm_triggered_by_id', '=', 'sender.id')
            ->where(function ($query) use ($request) {
                if ($request->senders_list) {
                    $query->whereIn('alarm_triggered_by_id', $request->senders_list);
                }

                if ($request->ecg_codes) {
                    $query->whereIn('ecg_code_id', $request->ecg_codes);
                }

                if ($request->receivers_list) {
                    $query->whereIn('respond_by_id', $request->receivers_list);
                }

                if ($request->locations_list) {
                    $query->whereIn('ecg_codes.location_id', $request->locations_list);
                }

                if ($request->locations_list) {
                    $query->whereIn('ecg_codes.location_id', $request->locations_list);
                }

                if (!empty($request->date_range)) {
                    $dateRangeAr = explode('/', $request->date_range);
                    $dateRangeAr[0] = AppHelper::getMySQLFormattedDate(trim($dateRangeAr[0]));
                    $dateRangeAr[1] = AppHelper::getMySQLFormattedDate(trim($dateRangeAr[1]));
                    $query->whereDate('ecg_alerts.alarm_triggered_at', '>=', "$dateRangeAr[0]");
                    $query->whereDate('ecg_alerts.alarm_triggered_at', '<=', "$dateRangeAr[1]");
                }


            })->orderByDesc('id');

        if ($limit) {
            return $query->limit($limit)->get();
        } else {
            return $query->paginate(8);
        }

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

    function location()
    {
        return $this->hasOne(LocationModel::class, 'id', 'location_id')->first();
    }

    function locationNME(): string
    {
        $location = $this->location();
        return $location instanceof LocationModel ? $location->locationName() : '-';
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
        } else {
            return false;
        }
    }

    function assignedUsers()
    {
        return EcgCodesAlertsAssignedToUsersModel::where('ecg_code_id', $this->ecg_code_id)->get();
    }

    public function unPlayedAlarmToAmplifier()
    {
        return EcgAlertsModel::whereNull('played_at_amplifier')
            ->leftJoin('ecg_codes', 'ecg_alerts.ecg_code_id', '=', 'ecg_codes.id')
            ->select('*')
            ->addSelect('ecg_alerts.id as id')
            ->whereNotNull("ecg_codes.tune_en")
            ->whereNotNull("ecg_codes.tune_ar")
            ->get();
    }

    public function playedToAmplifier($id)
    {
        return EcgAlertsModel::where('id', $id)->update([
            'played_at_amplifier' => AppHelper::getMySQLFormattedDateTime(Carbon::now())
        ]);
    }

    public function totalAlertReceives()
    {
        return EcgAlertsModel::count();
    }

    public function totalAccept()
    {
        return EcgAlertsModel::where('responded_action', 'accept')->count();
    }

    public function totalDecline()
    {
        return EcgAlertsModel::where('responded_action', 'reject')->count();
    }

    public function totalPlayedToAmplifier()
    {
        return EcgAlertsModel::whereNotNull('played_at_amplifier')->count();
    }

    public function emergencyCallsDashboardData(): array
    {
        return DB::select('
        SELECT
            SUBSTRING(YEAR(alarm_triggered_at), 3) AS year,
            MONTH(alarm_triggered_at) AS month,
            SUBSTRING(MONTHNAME(alarm_triggered_at),1,  3) AS month_name,
            CONCAT(SUBSTRING(YEAR(alarm_triggered_at), 3), " ",  SUBSTRING(MONTHNAME(alarm_triggered_at),1,  3)) as date,
            COUNT(*) AS total_count
        FROM
            ecg_alerts
        WHERE
            alarm_triggered_at >= DATE_SUB(CURDATE(), INTERVAL 7 MONTH)
        GROUP BY
            YEAR(alarm_triggered_at),
            MONTH(alarm_triggered_at)
        HAVING
            total_count > 0
        ORDER BY
            year DESC, month DESC;
        ');
    }

    public function amplifierCallsDashboardData(): array
    {
        return DB::select('
        SELECT
            SUBSTRING(YEAR(alarm_triggered_at), 3) AS year,
            MONTH(alarm_triggered_at) AS month,
            SUBSTRING(MONTHNAME(alarm_triggered_at),1,  3) AS month_name,
            CONCAT(SUBSTRING(YEAR(alarm_triggered_at), 3), " ",  SUBSTRING(MONTHNAME(alarm_triggered_at),1,  3)) as date,
            COUNT(*) AS total_count
        FROM
            ecg_alerts
        WHERE
            alarm_triggered_at >= DATE_SUB(CURDATE(), INTERVAL 7 MONTH) AND played_at_amplifier IS NOT NULL
        GROUP BY
            YEAR(alarm_triggered_at),
            MONTH(alarm_triggered_at)
        HAVING
            total_count > 0
        ORDER BY
            year DESC, month DESC;
        ');
    }
}
