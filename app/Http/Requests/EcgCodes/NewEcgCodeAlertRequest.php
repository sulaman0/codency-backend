<?php

namespace App\Http\Requests\EcgCodes;

use App\AppHelper\AppHelper;
use App\Http\Requests\ApiFormRequest;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class NewEcgCodeAlertRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $loggedInUser = AppHelper::getUserFromRequest($this);
        $groupId = User::groupsIds($loggedInUser->id);
        return [
            'code_id' => [
                'required',
                Rule::exists('ecg_codes_assigned_users', 'ecg_code_id')->whereIn('group_id', $groupId)
            ]
        ];
    }
}
