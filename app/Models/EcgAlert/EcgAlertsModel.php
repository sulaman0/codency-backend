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
                'ecg_alerts.responded_action',
                'ecg_alerts.played_type',
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
            ->where('should_play_to_amplifier', 1)
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
                DATE_ADD(CURDATE(), INTERVAL (1 - n) DAY) AS alarm_date,
                DAY(DATE_ADD(CURDATE(), INTERVAL (1 - n) DAY)) AS day,
                MONTH(DATE_ADD(CURDATE(), INTERVAL (1 - n) DAY)) AS month,
                SUBSTRING(MONTHNAME(DATE_ADD(CURDATE(), INTERVAL (1 - n) DAY)), 1, 3) AS month_name,
                COUNT(ecg_alerts.alarm_triggered_at) AS total_count
            FROM (
                SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
            ) AS numbers
            LEFT JOIN ecg_alerts ON DATE_ADD(CURDATE(), INTERVAL (1 - n) DAY) = DATE(ecg_alerts.alarm_triggered_at)
            WHERE DATE_ADD(CURDATE(), INTERVAL (1 - n) DAY) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY alarm_date, day, month
            ORDER BY alarm_date ASC ;
        ');
    }

    public function amplifierCallsDashboardData(): array
    {
        return DB::select("
SELECT
    DateRange.alarm_date,
    DAY(DateRange.alarm_date) AS day,
    MONTH(DateRange.alarm_date) AS month,
    SUBSTRING(MONTHNAME(DateRange.alarm_date), 1, 3) AS month_name,
    DATE_FORMAT(DateRange.alarm_date, '%y %b') AS date,
    COUNT(ecg_alerts.alarm_triggered_at) AS total_count
FROM (
    SELECT CURDATE() - INTERVAL (n - 1) DAY AS alarm_date
    FROM (
        SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
    ) AS numbers
) AS DateRange
LEFT JOIN ecg_alerts ON DATE(ecg_alerts.alarm_triggered_at) = DateRange.alarm_date
WHERE DateRange.alarm_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    AND (ecg_alerts.played_at_amplifier IS NULL OR ecg_alerts.played_at_amplifier IS NOT NULL)
GROUP BY DateRange.alarm_date, day, month
ORDER BY DateRange.alarm_date ASC;

        ");
    }
}
