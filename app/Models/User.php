<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\AppHelper\AppHelper;
use App\Http\Requests\Auth\Profile\UpdatePasswordRequest;

use App\Models\EcgCodes\EcgCodesAssignedToUsersModel;
use App\Models\Locations\LocationModel;
use App\Models\Users\UserDeviceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
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
        $location = $this->location()->first();
        if ($location instanceof LocationModel) {
            $lString = $location->loc_nme;
            if (!empty($location->room)) {
                $lString .= " " . $location->room;
            }

            if (!empty($location->floor)) {
                $lString .= " " . $location->floor;
            }

            if (!empty($location->building_nme)) {
                $lString .= " " . $location->building_nme;
            }

            return $lString;
        } else {
            return '-';
        }
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

    function getAllUsersForSearch($search = null)
    {
        $users = User::where('id', '<>', 0);
        if ($search) {
            $users = $users->where('name', 'LIKE', '%' . $search . '%');
        }
        return $users->get();
    }


    function getAllUsersAdmin(Request $request)
    {
        $users = User::where('id', '<>', 0);
        if ($request->search) {
            $users = $users->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->status && $request->status != 'all') {
            $users = $users->where('status', $request->status);
        }

        return $users->orderBy('id', 'desc')->paginate(10);
    }


    function userDeviceInformation()
    {
        return $this->hasOne(UserDeviceModel::class, 'user_id', 'id')->first();
    }

    function fcmToken(): string
    {
        $deviceInformation = $this->userDeviceInformation();
        if ($deviceInformation instanceof UserDeviceModel) {
            return $deviceInformation->fcm_token();
        } else {
            return '';
        }
    }

    public function createOrUpdateStaff(mixed $name, mixed $email, mixed $designation, mixed $phone, mixed $location, $password, $status, $id = null): bool
    {
        $M = $this->findById($id);
        $isNewUser = false;
        if (empty($M)) {
            $isNewUser = true;
            $M = new User();
        }

        $M->name = $name;
        $M->email = $email;
        $M->designation = $designation;
        $M->phone = $phone;
        $M->location_id = $location;
        if ($isNewUser) {
            $M->status = 'active';
        } else {
            $M->status = $status;
        }

        if ($password != 'testing09') {
            $M->password = Hash::make($password);
        }
        $M->save();
        return true;
    }

    function findById($id)
    {
        return User::find($id);
    }
}
