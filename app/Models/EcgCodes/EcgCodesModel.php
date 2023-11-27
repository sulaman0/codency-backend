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
        $M = EcgCodesModel::leftJoin('ecg_code_users', 'ecg_code_users.user_id', '=', $loggedInUserId);
        return $M->paginate();
    }
}
