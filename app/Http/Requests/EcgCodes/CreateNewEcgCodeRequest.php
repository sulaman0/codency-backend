<?php

namespace App\Http\Requests\EcgCodes;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateNewEcgCodeRequest extends ApiFormRequest
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
            'code_nme' => 'required|unique:ecg_codes,name',
            'action' => 'required|in:sent_to_amplifier_directly,sent_to_manager',
            'code' => 'required|unique:ecg_codes,code',
            'details' => 'nullable',
            'senders_list' => 'required',
            'senders_list.*' => 'required',
            'receivers_list' => 'required',
            'receivers_list.*' => 'required',
            'color_code' => 'required|unique:ecg_codes,color_code',
//            'lang' => 'required|in:en,ar',
//            'tune_en' => 'required',
//            'tune_ar' => 'required',
        ];
    }
}
