<?php

namespace App\Models\EcgCodes;

use App\AppHelper\AppHelper;
use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\RoomAndAlert\RoomAlertModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Lcobucci\JWT\Exception;

class EcgCodesModel extends Model
{
    use HasFactory;

    protected $table = 'ecg_codes';
    protected $fillable = [
        'status'
    ];

    public function getAllCodes($loggedInUserId)
    {
        $groupIds = User::groupsIds($loggedInUserId);
//        dump(EcgCodesAssignedToUsersModel
//            ::leftJoin('ecg_codes', 'ecg_codes_assigned_users.ecg_code_id', '=', 'ecg_codes.id')
//            ->whereIn('ecg_codes_assigned_users.group_id', $groupIds)
//            ->where('status', 'active')
//            ->orderBy('ecg_codes.id', 'asc')->getBindings());
//
//        dd(EcgCodesAssignedToUsersModel
//            ::leftJoin('ecg_codes', 'ecg_codes_assigned_users.ecg_code_id', '=', 'ecg_codes.id')
//            ->whereIn('ecg_codes_assigned_users.group_id', $groupIds)
//            ->where('status', 'active')
//            ->groupBy('code')
//            ->orderBy('ecg_codes.id', 'asc')->toSql());


        return EcgCodesAssignedToUsersModel
            ::select('ecg_codes.id as id')
            ->addselect('ecg_codes.name as name')
            ->addselect('ecg_codes.code as code')
            ->addselect('ecg_codes.color_code as color_code')
            ->leftJoin('ecg_codes', 'ecg_codes_assigned_users.ecg_code_id', '=', 'ecg_codes.id')
            ->whereIn('ecg_codes_assigned_users.group_id', $groupIds)
            ->where('status', 'active')
            ->orderBy('ecg_codes.id', 'asc')
            ->groupBy('code')
            ->paginate(100);
    }

    ## This one is for Admin Panel
    public function getAllCodesAdmin(Request $request)
    {
        $M = EcgCodesModel::where('id', '<>', 0);
        if ($request->search) {
            $M->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->status && $request->status != 'all') {
            $M->where('status', $request->status);
        }

        return $M->orderBy('id', 'desc')->paginate(6);

    }

    public function findById(mixed $code_id)
    {
        return EcgCodesModel::find($code_id);
    }


    ## This function returns all codes in Search Modal Box for Mobile APP Operation
    function getAllCodesForSearch($search = null)
    {
        $M = EcgCodesModel::where('id', '<>', 0);

        if ($search) {
            $M = $M->where(function ($M) use ($search) {
                $M->where('name', 'LIKE', '%' . $search . '%')->OrWhere('code', '%' . $search . '%');
            });
        }
        return $M->paginate(50);
    }

    function serialNo(): int
    {
        return (int)$this->id;
    }

    function code(): string
    {
        return (string)$this->code;
    }

    function action(): string
    {
        return $this->action == "sent_to_amplifier_directly" ? 'Sent To Amplifier Directly' : 'Sent To Manager';
    }

    function notifyBy(): string
    {
        return $this->sent_email == "yes" ? 'PN &  Email' : 'PN';
    }

    function assignedToUsers(): array
    {
        return $this->assignedToUsersObject()->get()->toArray();
    }

    function alertAssignedToUsers(): array
    {
        return $this->alertsAssignedToUsersObject()->get()->toArray();
    }

    function assignedToUsersIds(): array
    {
        return $this->assignedToUsersObject()->pluck('id')->toArray();
    }

    function alertAssignedToUsersIds(): array
    {
        return $this->alertsAssignedToUsersObject()->pluck('id')->toArray();
    }

    function assignedToUsersObject(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EcgCodesAssignedToUsersModel::class, 'ecg_code_id', 'id')
            ->select('groups.name')
            ->addSelect('groups.description as designation')
            ->addSelect('groups.created_at')
            ->addSelect('groups.id')
            ->leftJoin('groups', 'ecg_codes_assigned_users.group_id', '=', 'groups.id');
    }

    function alertsAssignedToUsersObject(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EcgCodesAlertsAssignedToUsersModel::class, 'ecg_code_id', 'id')
            ->select('groups.name')
            ->addSelect('groups.description as designation')
            ->addSelect('groups.created_at')
            ->addSelect('groups.id')
            ->leftJoin('groups', 'ecg_codes_alert_assigned_users.group_id', '=', 'groups.id');
    }

    public function createEcgCode(
        mixed $code_nme, mixed $action,
        mixed $code, mixed $details, mixed $color_code,
        mixed $lang, $id = null,
        mixed $howManyNotificationPlayed = null
    ): EcgCodesModel
    {
        $M = $this->findById($id);
        if (empty($M)) {
            $M = new EcgCodesModel();
        }
        $M->name = $code_nme;
        $M->code = $code;
        $M->color_code = $color_code;
        $M->action = 'sent_to_amplifier_directly'; // $action;
        $M->details = $details;
        $M->preferred_lang = $lang;
        $M->no_of_times_play = $howManyNotificationPlayed ?: 1;
        $M->save();
        return $M;
    }

    function lastCallAt($id)
    {
        return EcgAlertsModel::where('ecg_code_id', $id)->orderBy('id', 'desc')->first();
    }

    public function totalCodePressed(mixed $id)
    {
        return EcgAlertsModel::where('ecg_code_id', $id)->count();
    }

    function getAllCodesForSearchNoPagination()
    {
        return EcgCodesModel::all();
    }


    function setAudioCompilingStatus($audioStatus = 'pending'): void
    {
        $this->audio_status = $audioStatus;
        $this->save();
    }

    function updateAction(): void
    {
        try {
            Log::error("Update audio value to null... from ecg alerts");
            // Update the status
            $this->setAudioCompilingStatus();

            // delete all audio files
            $disk = Storage::disk('audio');
            $allFiles = $disk->allFiles();
            $prefix = '_' . $this->id;

            // Filter files that start with the specified prefix
            $matchingFiles = array_filter($allFiles, function ($file) use ($prefix) {
                return str_starts_with(basename($file), $prefix);
            });

            foreach ($matchingFiles as $file) {
                Storage::disk('audio')->delete($file);
                if (Storage::disk('audio')->exists($file)) {
                    throw new \Exception("Audio file is not compiled from ecg alerts" . $this->id);
                }
            }

            // delete compiled record.
            RoomAlertModel::deleteByAlertId($this->id);
        } catch (Exception $exception) {
            AppHelper::reportError($exception, "Error When Setting Audio Value to NULL from ecg alerts");
        }
    }

}
