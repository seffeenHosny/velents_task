<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

abstract class AbstractFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if($this->wantsJson()){
            $errors = (new ValidationException($validator))->errors();
            throw new HttpResponseException(
                // $this->prepare_response(true, $validator->errors()->first(), __('validation.failed'), null, 422)
                message([] , $validator->errors()->first() , false,422)

            );
        }else{
            parent::failedValidation($validator);
        }
    }
}
