<?php

namespace App\Models\Misc;

use App\AppHelper\AppHelper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCodesModel extends Model
{
    use HasFactory;

    protected $table = 'verification_codes';
    protected $casts = [
        'expire_at' => 'datetime'
    ];

    public function generateCode($code, $userId, $expireAt, $type = 'reset_password')
    {
        $M = new VerificationCodesModel();
        $M->user_id = $userId;
        $M->code = $code;
        $M->is_used = 0;
        $M->expire_at = $expireAt;
        $M->type = $type;
        $M->save();

        return $M->code;
    }

    function findCodeById()
    {

    }

    function findCodeByCodeAndUserId($userId, $code, $type = 'reset_password')
    {
        return VerificationCodesModel::where('user_id', $userId)->where('code', $code)
            ->where('type', $type)->first();
    }

    function markCodeAsUsed($RPC, $userId)
    {
        $RPC->is_used = true;
        $RPC->verified_at = AppHelper::getMySQLFormattedDateTime(Carbon::now());
        $RPC->save();

        if ($RPC->type === 'verify_phone') {
            $LoggedInUser = User::getUserById($userId);
            $LoggedInUser->phone_verified_at = $RPC->verified_at;
            $LoggedInUser->save();
        }

    }
}

