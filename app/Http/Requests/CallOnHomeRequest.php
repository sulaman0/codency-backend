<?php

namespace App\Http\Requests;

use App\AppHelper\AppHelper;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CallOnHomeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return AppHelper::getUserFromRequest($this) instanceof User;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    #[ArrayShape(['fcm_token' => "string"])] public function rules(): array
    {
        return [
            'fcm_token' => 'required'
        ];
    }
}
