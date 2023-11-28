<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\AppHelper\AppHelper;
use App\Http\Requests\Auth\Profile\UpdatePasswordRequest;

use App\Models\EcgCodes\EcgCodesAssignedToUsersModel;
use App\Models\Locations\LocationModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    function ecgCodes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EcgCodesAssignedToUsersModel::class, 'user_id', 'id');
    }


    function location(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(LocationModel::class, 'id', 'location_id');
    }

    function locationNme(): string
    {
        $location = $this->location();
        return $location instanceof LocationModel ? $location->name : '-';
    }

    static function findUserByEmail($email): mixed
    {
        return User::where('email', $email)->first();
    }

    static function updateMyProfilePassword(UpdatePasswordRequest $request)
    {
        $LoggedInUser = AppHelper::getUserFromRequest($request);
        if ($LoggedInUser instanceof User) {
            $LoggedInUser->password = Hash::make($request->password);
            return $LoggedInUser->save();
        } else {
            return false;
        }
    }

    static function getProfileById(int $userId)
    {
        return User::findOrFail($userId);
    }
}
