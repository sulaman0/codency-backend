<?php

namespace App\Models\EcgCodes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcgCodesAssignedToUsersModel extends Model
{
    use HasFactory;

    protected $table = 'ecg_codes_assigned_users';
}
