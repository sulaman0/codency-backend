<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\AppHelper\AppHelper;
use App\Http\Requests\Auth\Profile\UpdatePasswordRequest;

use App\Models\EcgCodes\EcgCodesAssignedToUsersModel;
use App\Models\Locations\LocationModel;
use App\Models\Users\GroupsModel;
use App\Models\Users\GroupUserModel;
use App\Models\Users\UserDeviceModel;
use App\Notifications\Users\SendWelcomeEmailToUsersNotifications;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        return AppHelper::parseLocation($this->location()->first());
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

    public function getAllUsersForSearch($request = null, $all = false)
    {
        $users = User::where('id', '<>', 0);
        if (!empty($request->search)) {
            $users = $users->where('name', 'LIKE', '%' . $request->search . '%');
        }
        return $all ? $users->get() : $users->paginate();
    }


    public function getAllUsersAdmin(Request $request)
    {
        $users = User::where('id', '<>', 0);
        if ($request->search) {
            $users = $users->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->status && $request->status != 'all') {
            $users = $users->where('status', $request->status);
        }

        if ($request->group && $request->group != 'all') {
            $users = $users->whereIn('id', GroupUserModel::getStaffIds($request->group));
        }

        if ($request->ecg_code && $request->ecg_code != 'all') {
            $users = $users->whereIn('id', EcgCodesAssignedToUsersModel::getStaffIds($request->ecg_code));
        }

        return $users->orderBy('id', 'desc')->paginate(10);
    }


    public function userDeviceInformation()
    {
        return $this->hasOne(UserDeviceModel::class, 'user_id', 'id')->first();
    }

    public function fcmToken(): string
    {
        $deviceInformation = $this->userDeviceInformation();
        if ($deviceInformation instanceof UserDeviceModel) {
            return $deviceInformation->fcm_token();
        } else {
            return '';
        }
    }

    public function createOrUpdateStaff(
        mixed $name, mixed $email,
        mixed $designation, mixed $phone,
        mixed $location, $password,
              $status, $id = null,
              $group = null
    ): bool
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

        if ($isNewUser) {
            $M->notify(new SendWelcomeEmailToUsersNotifications($password));
        } else {
            GroupUserModel::deleteByUserId($M->id);
        }

        if (!empty($group)) {
            GroupUserModel::saveUserGroupBulkInverse($group, $M->id);
        }
        return true;
    }

    static function findById($id)
    {
        return User::find($id);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(GroupsModel::class, 'group_user', 'user_id', 'group_id');
    }

    public function groupArray($onlyIds = false)
    {
        if ($onlyIds) {
            return $this->groups()->pluck('group_id')->toArray();
        }
        return $this->groups()->get()->toArray();
    }

    public static function groupsIds($userId)
    {
        return GroupUserModel::where('user_id', $userId)->pluck('group_id')->toArray();
    }
}
