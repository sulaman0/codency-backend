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
        if ($this->step == 2) {
            return [
                'building' => 'required',
                'floor_name' => 'required',
            ];
        } else if ($this->step == 3) {
            return [
                'building' => 'required',
                'floor' => 'required',
                'room_name' => 'required',
            ];
        } else {
            return [
                'building_name' => 'required',
            ];
        }

    }
}
