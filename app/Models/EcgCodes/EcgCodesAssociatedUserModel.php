<?php

namespace App\Models\EcgCodes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcgCodesAssociatedUserModel extends Model
{
    use HasFactory;

    protected $table = 'ecg_code_users';
}
