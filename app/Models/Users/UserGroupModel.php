<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroupModel extends Model
{
    use HasFactory;

    protected $table = 'group_user';
}
