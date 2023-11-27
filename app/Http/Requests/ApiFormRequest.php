<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    function nestedToSingle(array $array)
    {
        $singleDimArray = [];

        foreach ($array as $item) {

            if (is_array($item)) {
                $singleDimArray = array_merge($singleDimArray, $this->nestedToSingle($item));

            } else {
                $singleDimArray[] = $item;
            }
        }

        return $singleDimArray;
    }

    /**
     * Handle a failed validation attempt.
     * @param Validator $validator
     * @return void
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->header('Accept') == 'application/json' || $this->header('ApiResponse') == 'application/json') {
            $errors = (new ValidationException($validator))->errors();
            $ErrorsArray = $this->nestedToSingle($errors);
            throw new HttpResponseException(
                response()->json(
                    [
                        'status' => false,
                        'errors' => $this->nestedToSingle($errors),
                        'message' => $ErrorsArray[0]
                    ], Response::HTTP_OK)
            );
        } else {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}
