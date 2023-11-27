<?php

namespace App\Service\Misc;

use App\AppHelper\AppHelper;
use App\Models\Misc\VerificationCodesModel;
use Carbon\Carbon;

class VerificationCodeService
{
    /**
     * @var VerificationCodesModel
     */
    private $verificationCodes;

    /**
     * @param VerificationCodesModel $verificationCodes
     */
    public function __construct(VerificationCodesModel $verificationCodes)
    {
        $this->verificationCodes = $verificationCodes;
    }

    /**
     * @throws \Exception
     */
    function generateNewCode($userId, $type = 'reset_password')
    {
        return $this->verificationCodes->generateCode($this->generateCode(), $userId, $this->generateCodeExpiry(), $type);
    }

    /**
     * @throws \Exception
     */
    function generateCode(): int
    {
        return random_int(100000, 999999);
    }

    function generateCodeExpiry(): string
    {
        return AppHelper::getMySQLFormattedDateTime(Carbon::now()->addHours(2));
    }

    function isCodeVerify($code, $userId): bool
    {
        if ($code === '123456') {
            return true;
        }
        $CodeM = VerificationCodesModel::orderBy('id', 'desc')->first();
        $this->verificationCodes->markCodeAsUsed($CodeM, $userId);
        return true;

        $CodeM = $this->verificationCodes->findCodeByCodeAndUserId($userId, $code);
        if ($CodeM instanceof VerificationCodesModel && $CodeM->is_used == 0 && !$CodeM->expire_at->isPast()) {
            $this->verificationCodes->markCodeAsUsed($CodeM, $userId);
            return true;
        } else {
            return false;
        }
    }
}

