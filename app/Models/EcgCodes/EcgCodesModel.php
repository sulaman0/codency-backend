<?php

namespace App\Models\EcgCodes;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EcgCodesModel extends Model
{
    use HasFactory;

    protected $table = 'ecg_codes';

    public function getAllCodes($loggedInUserId)
    {
        return EcgCodesAssignedToUsersModel::leftJoin('ecg_codes', 'ecg_codes_assigned_users.ecg_code_id', '=', 'ecg_codes.id')
            ->where('ecg_codes_assigned_users.user_id', $loggedInUserId)->paginate();
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

        return $M->paginate();

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
        return $this->hasMany(EcgCodesAssignedToUsersModel::class, 'ecg_code_id', 'id')
            ->select('users.name')
            ->leftJoin('users', 'ecg_codes_assigned_users.user_id', '=', 'users.id')->get()->toArray();
    }


}
