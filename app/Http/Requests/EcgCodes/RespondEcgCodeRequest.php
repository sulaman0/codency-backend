<?php

namespace App\Http\Requests\EcgCodes;

use App\Http\Requests\ApiFormRequest;
use JetBrains\PhpStorm\ArrayShape;

class RespondEcgCodeRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape(['action' => "mixed"])] function validationData()
    {
        return [
            'action' => $this->action,
        ];
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
                'in:accept,reject'
            ],
        ];
    }
}
