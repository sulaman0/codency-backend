<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\ApiFormRequest;

class CreateStaffRequest extends ApiFormRequest
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
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'designation' => 'required',
            'phone' => 'nullable',
            'location' => 'required',
            'floor' => 'required',
            'room' => 'required',
            'password' => 'required',
        ];

        if ($this->id) {
            $rules['email'] = 'required|unique:users,email,' . $this->id;
        }

        return $rules;
    }
}
