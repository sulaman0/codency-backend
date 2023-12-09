<?php

namespace App\Models\EcgCodes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcgCodesModel extends Model
{
    use HasFactory;

    protected $table = 'ecg_codes';

    public function getAllCodes($loggedInUserId)
    {
        return EcgCodesAssignedToUsersModel::leftJoin('ecg_codes', 'ecg_codes_assigned_users.ecg_code_id', '=', 'ecg_codes.id')
            ->where('ecg_codes_assigned_users.user_id', $loggedInUserId)->paginate();
    }

    public function findById(mixed $code_id)
    {
        return EcgCodesModel::find($code_id);
    }


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

}
