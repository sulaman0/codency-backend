<?php

namespace App\Http\Requests\Location;

use App\Http\Requests\ApiFormRequest;

class CreateLocationRequest extends ApiFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'loc_name' => 'required',
            'building_nme' => 'required',
        ];
    }
}
