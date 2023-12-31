<?php

namespace App\Models\EcgCodes;

use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EcgCodesModel extends Model
{
    use HasFactory;

    protected $table = 'ecg_codes';
    protected $fillable = [
        'status'
    ];

    public function getAllCodes($loggedInUserId)
    {
        return EcgCodesAssignedToUsersModel::leftJoin('ecg_codes', 'ecg_codes_assigned_users.ecg_code_id', '=', 'ecg_codes.id')
            ->where('ecg_codes_assigned_users.user_id', $loggedInUserId)->where('status', 'active')->orderBy('ecg_codes.id', 'asc')->paginate();
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
    function getAllCodesForSearch($search = null): \Illuminate\Database\Eloquent\Collection
    {
        $M = EcgCodesModel::where('id', '<>', 0);

        if ($search) {
            $M = $M->where(function ($M) use ($search) {
                $M->where('name', 'LIKE', '%' . $search . '%')->OrWhere('code', '%' . $search . '%');
            });
        }
        return $M->get();
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
            ->select('users.name')->addSelect('users.designation')->addSelect('users.created_at')->addSelect('users.id')
            ->leftJoin('users', 'ecg_codes_assigned_users.user_id', '=', 'users.id');
    }

    function alertsAssignedToUsersObject(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EcgCodesAlertsAssignedToUsersModel::class, 'ecg_code_id', 'id')
            ->select('users.name')->addSelect('users.designation')->addSelect('users.created_at')->addSelect('users.id')
            ->leftJoin('users', 'ecg_codes_alert_assigned_users.user_id', '=', 'users.id');
    }

    public function createEcgCode(mixed $code_nme, mixed $action, mixed $code, mixed $details, mixed $color_code, mixed $lang, $id = null): EcgCodesModel
    {
        $M = $this->findById($id);
        if (empty($M)) {
            $M = new EcgCodesModel();
        }
        $M->name = $code_nme;
        $M->code = $code;
        $M->color_code = $color_code;
        $M->action = $action;
        $M->details = $details;
        $M->preferred_lang = $lang;
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


}
