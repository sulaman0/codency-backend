<?php

namespace App\Http\Requests\EcgCodes;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class RespondEcgCodeRequest extends FormRequest
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
     * @return array
     */
    #[ArrayShape(['action' => "string[]"])] public function rules(): array
    {
        return [
            'action' => [
                'required',
                'in:accept|reject'
            ]
        ];
    }
}
