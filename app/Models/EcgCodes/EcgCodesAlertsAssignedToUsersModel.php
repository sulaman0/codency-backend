<?php

namespace App\Models\EcgCodes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcgCodesAlertsAssignedToUsersModel extends Model
{
    use HasFactory;

    protected $table = 'ecg_codes_alert_assigned_users';
}
